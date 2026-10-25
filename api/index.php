<?php

// Mengalihkan direktori cache & storage sementara ke folder /tmp Vercel
putenv('VIEW_COMPILED_PATH=/tmp');
$_ENV['VIEW_COMPILED_PATH'] = '/tmp';

require __DIR__ . '/../public/index.php';