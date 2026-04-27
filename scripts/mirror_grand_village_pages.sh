#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "$0")/.." && pwd)"
TMP_DIR="$(mktemp -d)"
trap 'rm -rf "$TMP_DIR"' EXIT

BASE_URL="https://grand-village.yokohama"

pages=(
  "archives/category/kokuban category-kokuban.html"
  "archives/category/lunch category-lunch.html"
  "archives/category/information category-information.html"
  "food food.html"
  "kids kids.html"
  "drink drink.html"
  "wine wine.html"
  "interior-exterior interior-exterior.html"
  "gallery gallery.html"
)

download_upload_asset() {
  local path="$1"
  local clean="${path%%\?*}"
  local dest="$ROOT_DIR/images/uploads/${clean#/wp/wp-content/uploads/}"
  mkdir -p "$(dirname "$dest")"
  if [[ ! -f "$dest" ]]; then
    curl -L -f --silent --show-error -o "$dest" "$BASE_URL$clean"
  fi
}

download_root_asset() {
  local path="$1"
  local clean="${path%%\?*}"
  local dest="$ROOT_DIR/${clean#/}"
  mkdir -p "$(dirname "$dest")"
  if [[ ! -f "$dest" ]]; then
    curl -L -f --silent --show-error -o "$dest" "$BASE_URL$clean"
  fi
}

rewrite_html() {
  local file="$1"

  perl -0pi -e '
    s#https://grand-village\.yokohama/wp/wp-content/themes/8thOcean/style\.css\?[^"]*#css/style.css#g;
    s#https://grand-village\.yokohama/wp/wp-content/themes/8thOcean/css/base\.css\?[^"]*#css/base.css#g;
    s#https://grand-village\.yokohama/wp/wp-includes/css/dist/block-library/style\.min\.css\?ver=[^"'\'' ]*#css/wp-block-library-style.min.css#g;
    s#https://ajax\.googleapis\.com/ajax/libs/jquery/3\.5\.1/jquery\.min\.js\?ver=3\.5\.1#js/jquery.min.js#g;
    s#https://grand-village\.yokohama/wp/wp-content/themes/8thOcean/js/([^"?]+)\?ver=[^"]*#js/$1#g;
    s#https://grand-village\.yokohama/wp/wp-content/themes/8thOcean/js/([^"]+)#js/$1#g;
    s#https://grand-village\.yokohama/wp/wp-content/themes/8thOcean/images/([^"?]+)(?:\?[^"]*)?#images/assets/$1#g;
    s#https://grand-village\.yokohama/favicon\.ico#favicon.ico#g;
    s#https://grand-village\.yokohama/wp/wp-content/uploads/#images/uploads/#g;
    s#(["(])/(wp/wp-content/uploads/)#$1images/uploads/#g;
    s#https://grand-village\.yokohama/images/auto_gal/#images/auto_gal/#g;
    s#(["(])/images/auto_gal/#$1images/auto_gal/#g;

    s#https://grand-village\.yokohama/archives/category/kokuban/?#category-kokuban.html#g;
    s#https://grand-village\.yokohama/archives/category/lunch/?#category-lunch.html#g;
    s#https://grand-village\.yokohama/archives/category/information/?#category-information.html#g;
    s#https://grand-village\.yokohama/food/?#food.html#g;
    s#https://grand-village\.yokohama/kids/?#kids.html#g;
    s#https://grand-village\.yokohama/drink/?#drink.html#g;
    s#https://grand-village\.yokohama/wine/?#wine.html#g;
    s#https://grand-village\.yokohama/interior-exterior/?#interior-exterior.html#g;
    s#https://grand-village\.yokohama/gallery/?#gallery.html#g;
    s|https://grand-village\.yokohama/?(["#])|index.html$1|g;
    s#https://grand-village\.yokohama/#index.html#g;
    s#href="/#href="#g;
    s#href="archives/category/kokuban/?#href="category-kokuban.html#g;
    s#href="archives/category/lunch/?#href="category-lunch.html#g;
    s#href="archives/category/information/?#href="category-information.html#g;
    s#href="food/?#href="food.html#g;
    s#href="kids/?#href="kids.html#g;
    s#href="drink/?#href="drink.html#g;
    s#href="wine/?#href="wine.html#g;
    s#href="interior-exterior/?#href="interior-exterior.html#g;
    s#href="gallery/?#href="gallery.html#g;
    s|href="index\.html#home_access|href="index.html#home_access|g;
    s#(food|kids|drink|wine|interior-exterior|gallery)\.html\.html#$1.html#g;
    s#href="index\.htmlarchives/#href="https://grand-village.yokohama/archives/#g;
    s#href="archives/#href="https://grand-village.yokohama/archives/#g;
    s#href="category-([a-z-]+)\.htmlfeed"#href="https://grand-village.yokohama/archives/category/$1/feed"#g;
    s#href="category-([a-z-]+)\.htmlpage/([^"]+)"#href="https://grand-village.yokohama/archives/category/$1/page/$2"#g;
    s#<link rel="https://api\.w\.org/"[^>]+>\n?##g;
    s#<link rel="alternate" type="application/json"[^>]+>\n?##g;
    s#<link rel="EditURI"[^>]+>\n?##g;
    s#<link rel="alternate"[^>]+oembed[^>]+>\n?##g;
    s#\s*<script type="application/ld\+json" class="aioseo-schema">.*?</script>##s;
  ' "$file"
}

mkdir -p "$ROOT_DIR/scripts" "$ROOT_DIR/images/uploads"

for entry in "${pages[@]}"; do
  read -r remote output <<< "$entry"
  raw="$TMP_DIR/$output"
  curl -L -f --silent --show-error -o "$raw" "$BASE_URL/$remote"

  perl -nE 'while (m#(?:https://grand-village\.yokohama)?(/wp/wp-content/uploads/[^"'\'' )<>]+)#g) { say $1 }' "$raw" | sort -u |
    while IFS= read -r asset; do
      download_upload_asset "$asset"
    done

  perl -nE 'while (m#(?:https://grand-village\.yokohama)?(/images/auto_gal/[^"'\'' )<>]+)#g) { say $1 }' "$raw" | sort -u |
    while IFS= read -r asset; do
      download_root_asset "$asset"
    done

  cp "$raw" "$ROOT_DIR/$output"
  rewrite_html "$ROOT_DIR/$output"
done

perl -0pi -e '
  s#(<li id="menu-item-419"[^>]*><a href=")[^"]*#$1category-kokuban.html#;
  s#(<li id="menu-item-104"[^>]*><a href=")[^"]*#$1category-lunch.html#;
  s#(<li id="menu-item-21"[^>]*><a href=")[^"]*#$1food.html#;
  s#(<li id="menu-item-274"[^>]*><a href=")[^"]*#$1kids.html#;
  s#(<li id="menu-item-22"[^>]*><a href=")[^"]*#$1drink.html#;
  s#(<li id="menu-item-23"[^>]*><a href=")[^"]*#$1wine.html#;
  s#(<li id="menu-item-660"[^>]*><a href=")[^"]*#$1interior-exterior.html#;
  s#(<li id="menu-item-604"[^>]*><a href=")[^"]*#$1gallery.html#;
  s#href="https://grand-village\.yokohama/archives/category/information/"#href="category-information.html"#g;
  s#href="https://grand-village\.yokohama#href="#g;
  s#href="/archives/#href="archives/#g;
  s|<h1 class="logo" ><a href="#">|<h1 class="logo" ><a href="index.html">|;
  s|Copyright &copy; <a href="#">|Copyright &copy; <a href="index.html">|;
' "$ROOT_DIR/index.html"
