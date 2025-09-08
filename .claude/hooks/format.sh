#!/usr/bin/env bash

# Auto-format code after Write/Edit operations
# Formats TypeScript, JavaScript, JSON, and Markdown files

set -e

CHANGED_FILE="$1"

if [[ -z "$CHANGED_FILE" ]]; then
    echo "No file specified for formatting"
    exit 0
fi

# Check if file exists and is in project directory
if [[ ! -f "$CHANGED_FILE" ]]; then
    echo "File does not exist: $CHANGED_FILE"
    exit 0
fi

# Get file extension
EXT="${CHANGED_FILE##*.}"

case "$EXT" in
    "ts"|"tsx"|"js"|"jsx"|"json"|"md")
        if command -v prettier >/dev/null 2>&1; then
            prettier --write "$CHANGED_FILE" 2>/dev/null || echo "Prettier formatting failed"
        elif command -v npx >/dev/null 2>&1; then
            npx prettier --write "$CHANGED_FILE" 2>/dev/null || echo "Prettier formatting failed"
        fi
        ;;
    "py")
        if command -v black >/dev/null 2>&1; then
            black "$CHANGED_FILE" 2>/dev/null || echo "Black formatting failed"
        fi
        ;;
    *)
        echo "No formatter configured for .$EXT files"
        ;;
esac

echo "Auto-formatted: $CHANGED_FILE"
