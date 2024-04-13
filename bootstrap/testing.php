<?php
// configがキャッシュされている場合、テスト時に予期しないconfig設定で実行して
// DBが吹っ飛ぶのを防ぐため、念の為configファイルのキャッシュを事前にクリアする
system('php artisan config:clear');

require_once __DIR__ . '/../vendor/autoload.php';
