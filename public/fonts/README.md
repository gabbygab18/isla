# Brand Webfonts

The site is wired for two licensed typefaces:

- **Latom Grotesque** (Skinny Type) — headings
- **LTS Raela Pro** (Lettertype Studio) — body text

Both are commercial fonts. Purchase webfont licenses (e.g. via MyFonts),
then drop the .woff2 files into this folder with these exact filenames:

    LatomGrotesque-Regular.woff2
    LatomGrotesque-Medium.woff2
    LatomGrotesque-SemiBold.woff2
    LatomGrotesque-Bold.woff2
    LTSRaelaPro-Regular.woff2
    LTSRaelaPro-Italic.woff2
    LTSRaelaPro-Medium.woff2
    LTSRaelaPro-SemiBold.woff2
    LTSRaelaPro-Bold.woff2

No code changes needed — the @font-face rules in layouts/app.blade.php
pick them up automatically. Until the files are present, the site falls
back to Inter so nothing breaks.

If your webfont kit ships different weight names, either rename the files
to match the list above or adjust the @font-face src paths in the layout.
