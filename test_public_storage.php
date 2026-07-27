<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$fileInStorage = storage_path('app/public/products/2N7bexxnOPgirCtukefXKZove0u7UvKNvhblOBbV.png');
$fileInPublic = public_path('storage/products/2N7bexxnOPgirCtukefXKZove0u7UvKNvhblOBbV.png');

echo "File in storage_path exists? " . (file_exists($fileInStorage) ? "YES" : "NO") . "\n";
echo "File in public_path exists? " . (file_exists($fileInPublic) ? "YES" : "NO") . "\n";

echo "Public Path: " . public_path('storage') . "\n";
if (is_link(public_path('storage'))) {
    echo "public/storage IS A SYMLINK pointing to: " . readlink(public_path('storage')) . "\n";
} else if (is_dir(public_path('storage'))) {
    echo "public/storage IS A DIRECTORY (not a symlink)\n";
} else {
    echo "public/storage DOES NOT EXIST\n";
}
