#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

VERSION="$(awk -F ': ' '/^Version:/ { print $2; exit }' style.css)"

if [[ -z "$VERSION" ]]; then
	echo "Unable to determine theme version from style.css" >&2
	exit 1
fi

BUILD_DIR="$ROOT_DIR/build"
DIST_DIR="$BUILD_DIR/vaarta"
ZIP_NAME="vaarta-$VERSION.zip"

rm -rf "$BUILD_DIR"
mkdir -p "$DIST_DIR"

items=(
	assets
	blocks
	docs
	inc
	parts
	patterns
	styles
	templates
	tools
	functions.php
	style.css
	theme.json
	README.md
	CHANGELOG.md
	LICENSE.md
)

for item in "${items[@]}"; do
	if [[ ! -e "$item" ]]; then
		echo "Required package item missing: $item" >&2
		exit 1
	fi

	cp -R "$item" "$DIST_DIR/"
done

find "$DIST_DIR" -name '.DS_Store' -delete

(
	cd "$BUILD_DIR"
	zip -qr "$ZIP_NAME" vaarta
)

if unzip -l "$BUILD_DIR/$ZIP_NAME" | grep -Eq '(^|/)(\.git|\.github|node_modules|tests|playwright-report|test-results)(/|$)'; then
	echo "Development-only files leaked into package." >&2
	exit 1
fi

echo "$BUILD_DIR/$ZIP_NAME"
