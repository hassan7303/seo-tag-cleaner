[contributors-shield]: https://img.shields.io/github/contributors/hassan7303/seo-tag-cleaner.svg?style=for-the-badge
[contributors-url]: https://github.com/hassan7303/seo-tag-cleaner/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/hassan7303/seo-tag-cleaner.svg?style=for-the-badge&label=Fork
[forks-url]: https://github.com/hassan7303/seo-tag-cleaner/network/members
[stars-shield]: https://img.shields.io/github/stars/hassan7303/seo-tag-cleaner.svg?style=for-the-badge
[stars-url]: https://github.com/hassan7303/seo-tag-cleaner/stargazers
[license-shield]: https://img.shields.io/github/license/hassan7303/seo-tag-cleaner.svg?style=for-the-badge
[license-url]: https://github.com/hassan7303/seo-tag-cleaner/blob/master/LICENSE.md
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-blue.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://www.linkedin.com/in/hassan-ali-askari-280bb530a/
[telegram-shield]: https://img.shields.io/badge/-Telegram-blue.svg?style=for-the-badge&logo=telegram&colorB=555
[telegram-url]: https://t.me/hassan7303
[instagram-shield]: https://img.shields.io/badge/-Instagram-red.svg?style=for-the-badge&logo=instagram&colorB=555
[instagram-url]: https://www.instagram.com/hasan_ali_askari
[github-shield]: https://img.shields.io/badge/-GitHub-black.svg?style=for-the-badge&logo=github&colorB=555
[github-url]: https://github.com/hassan7303
[email-shield]: https://img.shields.io/badge/-Email-orange.svg?style=for-the-badge&logo=gmail&colorB=555
[email-url]: mailto:hassanali7303@gmail.com
[website-shield]: https://img.shields.io/badge/-Website-blue.svg?style=for-the-badge&logo=laravel&colorB=555
[website-url]: https://hsnali.ir


[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![MIT License][license-shield]][license-url]
[![LinkedIn][linkedin-shield]][linkedin-url]
[![Telegram][telegram-shield]][telegram-url]
[![Instagram][instagram-shield]][instagram-url]
[![GitHub][github-shield]][github-url]
[![Email][email-shield]][email-url]
[![Website][website-shield]][website-url]


# SEO Tag Cleaner

**Version:** 1.1  
**Author:** Your Name  
**Description:** This WordPress plugin optimizes HTML tags for SEO by managing duplicate `<h1>`, `<footer>`, and `<header>` tags on the page.

---

## Features

- **H1 Tag Management:**  
  Ensures only one `<h1>` tag exists on a page. Any additional `<h1>` tags are converted to `<h2>`.

- **Footer Management:**  
  Identifies the main `<footer>` tag based on its content. Additional `<footer>` tags are replaced with `<div>` tags.

- **Header Management:**  
  Identifies the main `<header>` tag and replaces duplicate `<header>` tags with `<div>` tags.

- **Buffering for Full HTML:**  
  Processes the entire page HTML output to ensure compatibility with all themes and plugins.

---

## Installation

1. **Download the Plugin**  
   Save the plugin code as `seo-tag-cleaner.php`.

2. **Upload to WordPress**  
   Place the file in the following directory:
   wp-content/plugins/seo-tag-cleaner/
3. **Activate the Plugin**  
Log in to your WordPress dashboard, go to **Plugins**, and activate **SEO Tag Cleaner**.

---

## How It Works

The plugin intercepts the HTML output using the `template_redirect` and `shutdown` hooks. It processes the HTML using `DOMDocument` to identify and manipulate the following elements:

1. **H1 Tags:**  
- Keeps the first `<h1>` tag.
- Converts additional `<h1>` tags to `<h2>`.

2. **Footer Tags:**  
- Determines the main `<footer>` tag based on its content length.
- Replaces other `<footer>` tags with `<div>`.

3. **Header Tags:**  
- Determines the main `<header>` tag based on its content length.
- Replaces other `<header>` tags with `<div>`.

---

## Customization

### Modify Main Element Selection
To change how the main `<footer>` or `<header>` tag is determined, update the `find_main_element()` function. The current implementation uses content length to decide.

---

## Troubleshooting

- **No Changes Visible:**  
Ensure your theme outputs standard HTML tags and the content includes the elements (`<h1>`, `<footer>`, `<header>`) to modify.

- **Compatibility Issues:**  
If the plugin conflicts with other plugins or customizations, disable it and verify the issue.
