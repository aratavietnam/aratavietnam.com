#!/bin/sh
# Script to list all posts and their assigned tags.

set -e

echo "Waiting for the database to be ready..."
sleep 10

echo "Fetching posts and their tags..."

for id in $(wp post list --post_type=post --format=ids --allow-root); do
  echo "---"
  TITLE=$(wp post get $id --field=post_title --allow-root)
  echo "Post: $TITLE"
  echo "Tags:"
  wp post term list $id post_tag --fields=name --allow-root

done

echo "---"
echo "Script finished successfully."
