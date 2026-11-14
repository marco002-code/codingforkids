#!/usr/bin/env bash
# Wrapper to root deploy.sh
set -e
PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
exec "$PROJECT_DIR/deploy.sh" "$@"
