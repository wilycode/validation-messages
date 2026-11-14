# Contributing translations

Add or update `languages/<code>/validation.php` with the same keys as `languages/en/validation.php`.

- Use ISO 639-1 two-letter codes already used in this repository.
- Keep all placeholders unchanged, including `{min}`, `{max}`, `{format}`, `{fieldLabel}`, `{sizeMin}`, `{sizeMax}`, `{sizeUnit}` and `{extensions}`.
- Keep protocol syntax (`http://`, `https://`) and technical identifiers (JSON, UUID, URL, IP, HH:MM) intact.
- Prefer natural, concise, neutral text suitable for a web form.
- If a language uses inflection, use phrasing that reads correctly for arbitrary numeric placeholders.
- Run `php tests/validate.php` and PHP syntax checks before submitting a pull request.
- Describe whether a native speaker reviewed the wording; automated tests cannot judge translation quality.

The files are intentionally framework independent and can be copied directly into applications.
