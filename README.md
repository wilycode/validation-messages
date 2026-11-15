# WilyCode Validation Messages

Ready-to-copy, multilingual validation error messages for WilyCode validators in **25 languages**. Copy only the languages you need; there are **no runtime dependencies, no Composer requirement, and no Packagist publication**.

## Available languages

This collection covers **all 24 official languages of the European Union**, plus Ukrainian.

| Code | Language |
| --- | --- |
| `bg` | Bulgarian |
| `cs` | Czech |
| `da` | Danish |
| `de` | German |
| `el` | Greek |
| `en` | English |
| `es` | Spanish |
| `et` | Estonian |
| `fi` | Finnish |
| `fr` | French |
| `ga` | Irish |
| `hr` | Croatian |
| `hu` | Hungarian |
| `it` | Italian |
| `lt` | Lithuanian |
| `lv` | Latvian |
| `mt` | Maltese |
| `nl` | Dutch |
| `pl` | Polish |
| `pt` | Portuguese (European) |
| `ro` | Romanian |
| `sk` | Slovak |
| `sl` | Slovenian |
| `sv` | Swedish |
| `uk` | Ukrainian |

Each language file contains the same **46 translation keys**, covering required fields, strings, numbers, dates, URLs, email, file uploads, CSRF and anti-spam verification. English and Polish messages originate from Wily Starter. Translations are community-ready drafts; native-speaker review is recommended before production use, especially for languages with grammatical inflection.

## Repository structure

```text
validation-messages/
├── languages/
│   ├── bg/validation.php
│   ├── cs/validation.php
│   ├── da/validation.php
│   ├── de/validation.php
│   ├── el/validation.php
│   ├── en/validation.php
│   ├── es/validation.php
│   ├── et/validation.php
│   ├── fi/validation.php
│   ├── fr/validation.php
│   ├── ga/validation.php
│   ├── hr/validation.php
│   ├── hu/validation.php
│   ├── it/validation.php
│   ├── lt/validation.php
│   ├── lv/validation.php
│   ├── mt/validation.php
│   ├── nl/validation.php
│   ├── pl/validation.php
│   ├── pt/validation.php
│   ├── ro/validation.php
│   ├── sk/validation.php
│   ├── sl/validation.php
│   ├── sv/validation.php
│   └── uk/validation.php
├── tests/validate.php
├── .gitattributes
├── .gitignore
├── CHANGELOG.md
├── LICENSE
└── README.md
```

## Installation: copy from GitHub

Clone the repository or use **Code → Download ZIP**, then copy the files you want to your application:

```bash
git clone https://github.com/wilycode/validation-messages.git
cp validation-messages/languages/de/validation.php my-app/languages/de/validation.php
cp validation-messages/languages/en/validation.php my-app/languages/en/validation.php
```

If `validation.php` already exists in your application, **merge custom messages before replacing the file**. The PHP translation arrays can be edited freely. `validation-messages` does not implement validators, configure translations, or replace the application's error formatter.

## Using the WilyCode translator

With [wilycode/translation-array](https://github.com/wilycode/translation-array), point the translator to the application's language directory. Install the desired language implementations, or provide your own `LanguageInterface` implementation where necessary.

```php
use WilyCode\Translation\Language\En;
use WilyCode\Translation\Language\Pl;
use WilyCode\TranslationArray\ArrayTranslator;

$translator = new ArrayTranslator(
    directory: __DIR__ . '/languages',
    language: new En(),
    fallbackLanguage: new Pl(),
);

echo $translator->translate('validation', 'not_empty.required');
// This field is required.

echo $translator->translate('validation', 'string_length.too_short', ['min' => 5]);
// Enter at least 5 characters.
```

With [wilycode/template-translation](https://github.com/wilycode/template-translation):

```tpl
{{ 'csrf_token.invalid' | trans('validation') }}
```

WilyCode validators return error codes such as `validation.string_length.too_short`. When looking up a key in the **`validation` resource**, remove the leading `validation.` prefix. The application-specific `App\Form\ValidationErrorFormatter` from Wily Starter remains in Starter.

## Customization and contributions

- Translation parameters use `{name}` syntax (e.g. `{min}`, `{max}`, `{fieldLabel}`, `{sizeMin}`, `{sizeUnit}`). **Never translate these parameter names.**
- Keep every language catalog's keys and parameters aligned with English.
- You can submit language corrections and further languages through pull requests.
- Escape translated values appropriately in HTML; translation strings are not sanitized by this repository.

## Tests

The project uses no Composer dependencies. Run the self-contained PHP checks:

```bash
php tests/validate.php
```

The test verifies every present language directory, matching keys, nonempty messages, and matching placeholders. It cannot verify linguistic quality.

## Distribution

This repository is intended to be shared directly through GitHub. It does **not** contain a `composer.json` or require Packagist.

## Related projects

- [wilycode/validator](https://github.com/wilycode/validator) — validator contracts and error codes.
- [wilycode/validators](https://github.com/wilycode/validators) — ready-to-use validators.
- [wilycode/translation-array](https://github.com/wilycode/translation-array) — array-backed translation provider.
- [wilycode/template-translation](https://github.com/wilycode/template-translation) — template translation filters.

## License

MIT. See [LICENSE](LICENSE).
