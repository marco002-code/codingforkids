<?php

namespace App\Services;

/**
 * Pure PHP QR Code Generator (SVG).
 * Based on QR Code Model 2 (ISO/IEC 18004).
 * Zero external dependencies.
 */
class QrCodeService
{
    // Error correction levels
    public const EC_L = 1; // 7%
    public const EC_M = 0; // 15%
    public const EC_Q = 3; // 25%
    public const EC_H = 2; // 30%

    // Mode
    private const MODE_8BIT_BYTE = 4;

    private static array $EXP_TABLE = [];
    private static array $LOG_TABLE = [];
    private static bool $tablesInitialized = false;

    private static function initTables(): void
    {
        if (self::$tablesInitialized) return;
        self::$EXP_TABLE = array_fill(0, 256, 0);
        self::$LOG_TABLE = array_fill(0, 256, 0);
        $val = 1;
        for ($i = 0; $i < 255; $i++) {
            self::$EXP_TABLE[$i] = $val;
            self::$LOG_TABLE[$val] = $i;
            $val = ($val << 1);
            if ($val & 0x100) {
                $val ^= 0x11D;
            }
        }
        self::$tablesInitialized = true;
    }

    private static function glog(int $n): int
    {
        self::initTables();
        if ($n < 1) throw new \InvalidArgumentException("log($n)");
        return self::$LOG_TABLE[$n];
    }

    private static function gexp(int $n): int
    {
        self::initTables();
        while ($n < 0) $n += 255;
        while ($n >= 255) $n -= 255;
        return self::$EXP_TABLE[$n];
    }

    // RS Polynomial multiply
    private static function polyMultiply(array $p1, array $p2): array
    {
        $res = array_fill(0, count($p1) + count($p2) - 1, 0);
        for ($i = 0; $i < count($p1); $i++) {
            for ($j = 0; $j < count($p2); $j++) {
                $res[$i + $j] ^= self::gexp(self::glog($p1[$i]) + self::glog($p2[$j]));
            }
        }
        return $res;
    }

    private static function getErrorCorrectPolynomial(int $errorCorrectLength): array
    {
        $a = [1];
        for ($i = 0; $i < $errorCorrectLength; $i++) {
            $a = self::polyMultiply($a, [1, self::gexp($i)]);
        }
        return $a;
    }

    // Table of capacity & RS blocks for Versions 1..10 (more than enough for URLs and 5-letter codes)
    // [total_data_codewords, ec_codewords_per_block, num_blocks_g1, data_cw_g1, num_blocks_g2, data_cw_g2]
    private static array $RS_BLOCK_TABLE = [
        // Level M (15% correction)
        self::EC_M => [
            1 => [16, 10, 1, 16, 0, 0],
            2 => [28, 16, 1, 28, 0, 0],
            3 => [44, 26, 1, 44, 0, 0],
            4 => [64, 18, 2, 32, 0, 0],
            5 => [86, 24, 2, 43, 0, 0],
            6 => [108, 16, 4, 27, 0, 0],
            7 => [124, 18, 4, 31, 0, 0],
            8 => [154, 22, 2, 38, 2, 39],
            9 => [182, 22, 3, 36, 2, 37],
            10 => [216, 26, 4, 43, 1, 44],
        ]
    ];

    private static array $PATTERN_POS = [
        1 => [],
        2 => [6, 18],
        3 => [6, 22],
        4 => [6, 26],
        5 => [6, 30],
        6 => [6, 34],
        7 => [6, 22, 38],
        8 => [6, 24, 42],
        9 => [6, 26, 46],
        10 => [6, 28, 50],
    ];

    /**
     * Generate SVG string for given text.
     */
    public static function svg(string $text, int $size = 200, int $ecLevel = self::EC_M, string $darkColor = '#0b2347', string $lightColor = '#ffffff'): string
    {
        $matrix = self::generateMatrix($text, $ecLevel);
        $moduleCount = count($matrix);
        $quietZone = 4;
        $totalModules = $moduleCount + ($quietZone * 2);

        $path = '';
        for ($r = 0; $r < $moduleCount; $r++) {
            for ($c = 0; $c < $moduleCount; $c++) {
                if ($matrix[$r][$c]) {
                    $x = $c + $quietZone;
                    $y = $r + $quietZone;
                    $path .= "M{$x},{$y}h1v1h-1z ";
                }
            }
        }

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {$totalModules} {$totalModules}" width="{$size}" height="{$size}" shape-rendering="crispEdges">
    <rect width="100%" height="100%" fill="{$lightColor}"/>
    <path d="{$path}" fill="{$darkColor}"/>
</svg>
SVG;
    }

    /**
     * Generate matrix of booleans (true = dark).
     */
    public static function generateMatrix(string $text, int $ecLevel = self::EC_M): array
    {
        // Choose minimum version that fits data
        $version = 1;
        $dataLen = strlen($text);
        while ($version <= 10) {
            $capacity = self::$RS_BLOCK_TABLE[$ecLevel][$version][0] - 3; // roughly minus header
            if ($dataLen <= $capacity) break;
            $version++;
        }
        if ($version > 10) $version = 10;

        $moduleCount = $version * 4 + 17;
        $modules = array_fill(0, $moduleCount, array_fill(0, $moduleCount, null));

        // 1. Position probe patterns (Finders)
        self::setupPositionProbePattern($modules, 0, 0, $moduleCount);
        self::setupPositionProbePattern($modules, $moduleCount - 7, 0, $moduleCount);
        self::setupPositionProbePattern($modules, 0, $moduleCount - 7, $moduleCount);

        // 2. Alignment patterns
        $pos = self::$PATTERN_POS[$version];
        for ($i = 0; $i < count($pos); $i++) {
            for ($j = 0; $j < count($pos); $j++) {
                $row = $pos[$i];
                $col = $pos[$j];
                if ($modules[$row][$col] !== null) continue;
                for ($r = -2; $r <= 2; $r++) {
                    for ($c = -2; $c <= 2; $c++) {
                        $modules[$row + $r][$col + $c] = ($r == -2 || $r == 2 || $c == -2 || $c == 2 || ($r == 0 && $c == 0));
                    }
                }
            }
        }

        // 3. Timing patterns
        for ($r = 8; $r < $moduleCount - 8; $r++) {
            if ($modules[$r][6] === null) $modules[$r][6] = ($r % 2 === 0);
            if ($modules[6][$r] === null) $modules[6][$r] = ($r % 2 === 0);
        }

        // Dark module
        $modules[4 * $version + 9][8] = true;

        // Create data codewords + EC codewords
        $data = self::createData($version, $ecLevel, $text);

        // Select best mask (or mask 0 for simplicity)
        $maskPattern = 0;
        self::setupTypeInfo($modules, $ecLevel, $maskPattern, $moduleCount);

        // Map data
        self::mapData($modules, $data, $maskPattern, $moduleCount);

        return $modules;
    }

    private static function setupPositionProbePattern(array &$modules, int $row, int $col, int $moduleCount): void
    {
        for ($r = -1; $r <= 7; $r++) {
            for ($c = -1; $c <= 7; $c++) {
                if ($row + $r < 0 || $moduleCount <= $row + $r || $col + $c < 0 || $moduleCount <= $col + $c) continue;
                if ((0 <= $r && $r <= 6 && ($c == 0 || $c == 6))
                    || (0 <= $c && $c <= 6 && ($r == 0 || $r == 6))
                    || (2 <= $r && $r <= 4 && 2 <= $c && $c <= 4)) {
                    $modules[$row + $r][$col + $c] = true;
                } else {
                    $modules[$row + $r][$col + $c] = false;
                }
            }
        }
    }

    private static function setupTypeInfo(array &$modules, int $ecLevel, int $maskPattern, int $moduleCount): void
    {
        $data = ($ecLevel << 3) | $maskPattern;
        // BCH 15, 5
        $d = $data << 10;
        while (self::getBCHDigit($d) - self::getBCHDigit(1335) >= 0) {
            $d ^= (1335 << (self::getBCHDigit($d) - self::getBCHDigit(1335)));
        }
        $bits = (($data << 10) | $d) ^ 21522;

        for ($i = 0; $i < 15; $i++) {
            $mod = (($bits >> $i) & 1) == 1;
            if ($i < 6) {
                $modules[$i][8] = $mod;
            } elseif ($i < 8) {
                $modules[$i + 1][8] = $mod;
            } else {
                $modules[$moduleCount - 15 + $i][8] = $mod;
            }

            if ($i < 8) {
                $modules[8][$moduleCount - $i - 1] = $mod;
            } elseif ($i < 9) {
                $modules[8][15 - $i - 1 + 1] = $mod;
            } else {
                $modules[8][15 - $i - 1] = $mod;
            }
        }
        $modules[8][8] = (($bits >> 7) & 1) == 1;
    }

    private static function getBCHDigit(int $data): int
    {
        $digit = 0;
        while ($data != 0) {
            $digit++;
            $data >>= 1;
        }
        return $digit;
    }

    private static function createData(int $version, int $ecLevel, string $text): array
    {
        $rsInfo = self::$RS_BLOCK_TABLE[$ecLevel][$version];
        $totalDataCount = $rsInfo[0];
        $ecCount = $rsInfo[1];

        // Bit buffer
        $buffer = [];
        $length = strlen($text);

        // Mode: 8bit byte (0100)
        self::putBits($buffer, self::MODE_8BIT_BYTE, 4);
        // Character count: 8 bits for versions 1..9
        self::putBits($buffer, $length, 8);
        for ($i = 0; $i < $length; $i++) {
            self::putBits($buffer, ord($text[$i]), 8);
        }

        // Terminator: 4 zeroes if buffer fits
        $totalBits = $totalDataCount * 8;
        if (count($buffer) + 4 <= $totalBits) {
            self::putBits($buffer, 0, 4);
        }
        // Pad to byte
        while (count($buffer) % 8 != 0) {
            $buffer[] = 0;
        }
        // Pad bytes
        $padBytes = [0xEC, 0x11];
        $padIdx = 0;
        while (count($buffer) < $totalBits) {
            self::putBits($buffer, $padBytes[$padIdx], 8);
            $padIdx = ($padIdx + 1) % 2;
        }

        // Convert buffer to data bytes
        $dataBytes = [];
        for ($i = 0; $i < count($buffer); $i += 8) {
            $byte = 0;
            for ($b = 0; $b < 8; $b++) {
                if ($buffer[$i + $b] == 1) $byte |= (1 << (7 - $b));
            }
            $dataBytes[] = $byte;
        }

        // Generate RS blocks
        $numBlocks1 = $rsInfo[2];
        $dataCount1 = $rsInfo[3];
        $numBlocks2 = $rsInfo[4];
        $dataCount2 = $rsInfo[5];

        $offset = 0;
        $blocks = [];
        $ecBlocks = [];
        $rsPoly = self::getErrorCorrectPolynomial($ecCount);

        for ($b = 0; $b < $numBlocks1; $b++) {
            $bData = array_slice($dataBytes, $offset, $dataCount1);
            $offset += $dataCount1;
            $blocks[] = $bData;
            $ecBlocks[] = self::calcEc($bData, $ecCount, $rsPoly);
        }
        for ($b = 0; $b < $numBlocks2; $b++) {
            $bData = array_slice($dataBytes, $offset, $dataCount2);
            $offset += $dataCount2;
            $blocks[] = $bData;
            $ecBlocks[] = self::calcEc($bData, $ecCount, $rsPoly);
        }

        // Interleave data bytes
        $finalData = [];
        $maxDataCount = max($dataCount1, $dataCount2);
        for ($i = 0; $i < $maxDataCount; $i++) {
            for ($b = 0; $b < count($blocks); $b++) {
                if ($i < count($blocks[$b])) {
                    $finalData[] = $blocks[$b][$i];
                }
            }
        }
        // Interleave EC bytes
        for ($i = 0; $i < $ecCount; $i++) {
            for ($b = 0; $b < count($ecBlocks); $b++) {
                $finalData[] = $ecBlocks[$b][$i];
            }
        }

        return $finalData;
    }

    private static function calcEc(array $data, int $ecCount, array $rsPoly): array
    {
        $num = array_merge($data, array_fill(0, $ecCount, 0));
        for ($i = 0; $i < count($data); $i++) {
            $lead = $num[$i];
            if ($lead != 0) {
                $logLead = self::glog($lead);
                for ($j = 0; $j < count($rsPoly); $j++) {
                    $num[$i + $j] ^= self::gexp($logLead + self::glog($rsPoly[$j]));
                }
            }
        }
        return array_slice($num, count($data));
    }

    private static function putBits(array &$buffer, int $val, int $len): void
    {
        for ($i = $len - 1; $i >= 0; $i--) {
            $buffer[] = ($val >> $i) & 1;
        }
    }

    private static function mapData(array &$modules, array $data, int $maskPattern, int $moduleCount): void
    {
        $byteIndex = 0;
        $bitIndex = 7;
        $rows = range(0, $moduleCount - 1);
        $inc = -1;
        $row = $moduleCount - 1;

        for ($col = $moduleCount - 1; $col > 0; $col -= 2) {
            if ($col == 6) $col--;
            while (true) {
                for ($c = 0; $c < 2; $c++) {
                    $targetCol = $col - $c;
                    if ($modules[$row][$targetCol] === null) {
                        $dark = false;
                        if ($byteIndex < count($data)) {
                            $dark = (($data[$byteIndex] >> $bitIndex) & 1) == 1;
                        }
                        // Mask 0: (row + col) % 2 == 0
                        $mask = (($row + $targetCol) % 2 == 0);
                        if ($mask) $dark = !$dark;

                        $modules[$row][$targetCol] = $dark;
                        $bitIndex--;
                        if ($bitIndex == -1) {
                            $byteIndex++;
                            $bitIndex = 7;
                        }
                    }
                }
                $row += $inc;
                if ($row < 0 || $moduleCount <= $row) {
                    $row -= $inc;
                    $inc = -$inc;
                    break;
                }
            }
        }
    }
}
