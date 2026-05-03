# phpBB Email Whitelist

A lightweight and privacy-aware phpBB 3.3.x extension that allows registrations only from selected email domains.

The extension adds an email domain whitelist check during user registration, ACP configuration, multilingual support, blocked attempt logging, and basic statistics for rejected email providers.

---

## Features

* Allow registrations only from selected email domains
* Manage allowed domains from the phpBB ACP
* Supports one domain per line, comma-separated and semicolon-separated values
* Supports wildcard subdomains such as `*.example.com`
* Custom registration error message
* Optional display of allowed domains in the error message
* Blocked attempt logging
* Privacy-friendly email storage modes:

  * Do not store email address
  * Store masked email address
  * Store full email address
* ACP statistics:

  * Total blocked attempts
  * Blocked attempts today
  * Blocked attempts in the last 7 days
  * Most blocked domains
  * Latest blocked attempts
* Multi-language support:

  * English
  * Bulgarian
* No phpBB core file edits required

---

## Configuration

After installation, go to:

```text
ACP → Extensions → Email Whitelist
```

From there you can configure:

* Whether the whitelist is enabled
* Allowed email domains
* Whether allowed domains are shown in the registration error message
* Custom error message
* Logging of blocked attempts
* Email storage mode

---

## Example Allowed Domains

```text
gmail.com
abv.bg
yahoo.com
outlook.com
hotmail.com
icloud.com
```

Wildcard subdomains are also supported:

```text
*.example.com
```

This allows emails such as:

```text
user@mail.example.com
user@community.example.com
```

But does not allow:

```text
user@example.com
```

unless `example.com` is also added directly.

---

## Privacy

The extension includes privacy-friendly logging options.

You can choose between:

### Do not store email address

Only the blocked domain and technical metadata are stored.

### Store masked email address

Example:

```text
j***@example.com
```

This is the recommended default option.

### Store full email address

Stores the complete email address.

Use this only if you really need it for moderation, security review, or anti-abuse investigation.

---

## Statistics

The ACP statistics panel shows:

* Total blocked attempts
* Blocked attempts today
* Blocked attempts in the last 7 days
* Most blocked domains
* Latest blocked attempts

This helps administrators understand which email providers are most often rejected.

## License

This project is released under the MIT License.

See the `LICENSE` file for details.

---

## Support

If you find a bug or want to suggest a feature, open an issue in the GitHub repository.
