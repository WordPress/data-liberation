# WEFG

Library for generating WordPress WXR from any CMS, including custom ones.

## Quick example

The WEFG library lets you describe a WXR file in PHP. You can generate valid WordPress import files from any CMS, including custom ones.

```php
$wxr = new WXRFile($settings);
$wxr->addPost(new Post(
    title: 'Hello World',
    content: '<p>Welcome to my site.</p>',
    authorLogin: 'admin',
    publishDate: '2024-01-01 12:00:00',
    slug: 'hello-world'
));
$wxr->save('export.xml');
```

`wefg-no-code` builds on the same idea, but helps AI agents generate the exporter itself. That makes it possible to create a WXR exporter in any language or framework and validate it against a real WordPress import workflow.

## Tools

- [WEFG](https://github.com/raicem/wefg) - PHP library for programmatically generating WXR files.
- [WEFG No Code](https://github.com/raicem/wefg-no-code) - Agent toolkit for generating and verifying WXR exporter code in any language.
