#!/usr/bin/env python3
"""Re-zip the custom theme for WordPress upload.

Usage:  python scripts/build-theme.py
Output: dist/nimbuscloud.zip

Stdlib only - no dependencies to install.
"""
import os
import sys
import zipfile

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
SRC = os.path.join(ROOT, "wp-content", "themes", "nimbuscloud")
DIST = os.path.join(ROOT, "dist")
OUT = os.path.join(DIST, "nimbuscloud.zip")

SKIP_DIRS = {".git", "node_modules", "__pycache__", ".idea", ".vscode"}
SKIP_FILES = {".DS_Store", "Thumbs.db"}


def main() -> int:
    if not os.path.isdir(SRC):
        print(f"ERROR: theme source not found: {SRC}", file=sys.stderr)
        return 1

    os.makedirs(DIST, exist_ok=True)
    if os.path.exists(OUT):
        os.remove(OUT)

    count = 0
    with zipfile.ZipFile(OUT, "w", zipfile.ZIP_DEFLATED) as z:
        for dirpath, dirnames, filenames in os.walk(SRC):
            dirnames[:] = [d for d in dirnames if d not in SKIP_DIRS]
            for name in sorted(filenames):
                if name in SKIP_FILES:
                    continue
                full = os.path.join(dirpath, name)
                rel = os.path.relpath(full, SRC).replace(os.sep, "/")
                z.write(full, f"nimbuscloud/{rel}")
                count += 1

    print(f"built {OUT}")
    print(f"  {count} files, {os.path.getsize(OUT)} bytes")
    print("\nUpload at: wp-admin -> Appearance -> Themes -> Add New -> Upload Theme")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
