<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$files = glob($root . '/languages/*/validation.php');
if ($files === false || $files === []) {
    fwrite(STDERR, "No language catalogs found.\n");
    exit(1);
}

$messages = [];
foreach ($files as $path) {
    $language = basename(dirname($path));
    if (!preg_match('/^[a-z]{2}$/D', $language)) {
        fwrite(STDERR, "Invalid language code: {$language}\n");
        exit(1);
    }

    $catalog = require $path;
    if (!is_array($catalog) || $catalog === []) {
        fwrite(STDERR, "Catalog {$language} must return a nonempty array.\n");
        exit(1);
    }

    foreach ($catalog as $key => $message) {
        if (!is_string($key) || !preg_match('/^[a-z0-9_]+(?:\.[a-z0-9_]+)*$/D', $key)) {
            fwrite(STDERR, "Invalid key in {$language}: " . var_export($key, true) . "\n");
            exit(1);
        }
        if (!is_string($message) || trim($message) === '') {
            fwrite(STDERR, "Empty or invalid message: {$language}.{$key}\n");
            exit(1);
        }
    }

    $messages[$language] = $catalog;
}

$expectedLanguages = ['bg', 'cs', 'da', 'de', 'el', 'en', 'es', 'et', 'fi', 'fr', 'ga', 'hr', 'hu', 'it', 'lt', 'lv', 'mt', 'nl', 'pl', 'pt', 'ro', 'sk', 'sl', 'sv', 'uk'];
$actualLanguages = array_keys($messages);
sort($actualLanguages);
if ($actualLanguages !== $expectedLanguages) {
    fwrite(STDERR, 'Expected languages: ' . implode(', ', $expectedLanguages) . "\n");
    fwrite(STDERR, 'Found languages: ' . implode(', ', $actualLanguages) . "\n");
    exit(1);
}

if (!isset($messages['en'], $messages['pl'])) {
    fwrite(STDERR, "Both en and pl catalogs are required.\n");
    exit(1);
}

$reference = array_keys($messages['en']);
sort($reference);

$placeholders = static function (string $message): array {
    preg_match_all('/\{([a-zA-Z][a-zA-Z0-9_]*)\}/', $message, $matches);
    $names = array_values(array_unique($matches[1]));
    sort($names);
    return $names;
};

foreach ($messages as $language => $catalog) {
    $keys = array_keys($catalog);
    sort($keys);
    if ($keys !== $reference) {
        fwrite(STDERR, "Language {$language} has different keys.\n");
        fwrite(STDERR, 'Missing: ' . implode(', ', array_diff($reference, $keys)) . "\n");
        fwrite(STDERR, 'Extra: ' . implode(', ', array_diff($keys, $reference)) . "\n");
        exit(1);
    }

    foreach ($reference as $key) {
        $expected = $placeholders($messages['en'][$key]);
        $actual = $placeholders($catalog[$key]);
        if ($actual !== $expected) {
            fwrite(STDERR, "Placeholder mismatch: {$language}.{$key}\n");
            exit(1);
        }
    }
}

if ($messages['en']['not_empty.required'] !== 'This field is required.') {
    fwrite(STDERR, "The expected validator code not_empty.required is missing or changed.\n");
    exit(1);
}

printf("OK: %d keys across %d language catalogs; placeholders match.\n", count($reference), count($messages));
