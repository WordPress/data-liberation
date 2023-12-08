# Kadence Blocks to WordPress Core blocks

There are a number of custom blocks from Kadence Blocks which have equivalent blocks built right into any new WordPress installation but, in many cases, they are intentionally designed to do a bit more than what these WordPress provided blocks can do. What follows is a brief outline of how to approach switching over if you decide that’s best and a run down comparing the custom blocks to WordPress Core blocks.

## Overview

First of all - a basic overview of what is involved.

1. Make a backup of your site or confirm with your host that a backup exists.
2. Examine which blocks from Kadence you’re currently using.
3. Evaluate which features you’re using for those blocks and confirm if they work with Core blocks (see below).
4. Switch the content over, ideally with a plan in place to ensure you switch everything over properly before disabling the Kadence blocks.


## Block Comparison

Anywhere ⚠️ is used that indicates missing functionality in a default WordPress installation.

**Row Layout:** can be recreated with the [Row block](https://wordpress.org/documentation/article/row-block/) which also supports padding, background colors, background image, borders, etc. They can also seamlessly be converted between Stack and Group blocks!

Advanced Gallery: can be recreated as a [Gallery block](https://wordpress.org/documentation/article/gallery-block/) with the ability to individually style each image to your liking, including taking advantage of the new lightbox feature coming to WordPress 6.4. What’s missing are the various layout options, like Carousels and Sliders.

**Form ⚠️:** there currently isn’t a comparable block built into WordPress but [work is underway](https://github.com/WordPress/gutenberg/pull/44214) to experiment with adding this functionality.

**Advanced Text ⚠️:** there currently isn’t a comparable block built into WordPress but, for themes with fluid typography in place like [Twenty Twenty-Three](https://wordpress.org/themes/twentytwentythree/) or [Twenty Twenty-Four](https://wordpress.org/themes/twentytwentyfour/), your content will automatically scale.

**Advanced Button:** can be recreated with the [Buttons block](https://wordpress.org/documentation/article/buttons-block/). Note that anytime you customize a button, when you create a new one in the same set, those same customizations will apply making for easy styling.

**Tabs ⚠️:** there currently isn’t a comparable block built into WordPress.

**Accordion:** can be recreated with the [Details block](https://wordpress.org/documentation/article/details-block/) for most designs.

**Testimonials:** can be recreated with a wide variety of blocks, including Columns and Images, or just pulled from the [Patterns Directory](https://wordpress.org/patterns/search/testimonials/), like this [customer quote](https://wordpress.org/patterns/pattern/testimonial-client-quote-customer-love/) or this [customer review](https://wordpress.org/patterns/pattern/testimonial-clients-review-section-design/). Once you have testimonials you like, remember that you can also save them as [your own custom pattern](https://wordpress.org/documentation/article/block-pattern/#how-to-use-a-block-pattern-2) for use across your site.

**Icon ⚠️:** there currently isn’t a comparable block built into WordPress but some aspects can be recreated by uploading icons to an Image block. Of note, SVG files [aren’t officially supported for upload](https://core.trac.wordpress.org/ticket/24251).

**Spacer/Divider:** can be recreated with the [Spacer block](https://wordpress.org/documentation/article/spacer-block/).

**Info Box:** can be recreated with a wide variety of blocks, including Columns and Images but [without animation that Kadence shows on their site](https://www.kadencewp.com/kadence-blocks/custom-blocks/info-box-block/).

**Icon List:** there currently isn’t this functionality in the [List block](https://wordpress.org/documentation/article/list-block/) but [there’s an issue open here](https://github.com/WordPress/gutenberg/issues/45830) around exploring what adding different options might look like.

**Countdown ⚠️:** there currently isn’t a comparable block built into WordPress.

**Posts:** can be recreated with the [Posts List block](https://wordpress.org/documentation/article/posts-list-block/) with pattern options built into the block that offers up different layout options.

**Table of Contents ⚠️:** there currently isn’t a comparable block built into WordPress but [there is work underway to change that](https://github.com/WordPress/gutenberg/issues/42229).

**Lottie Animation ⚠️:** there currently isn’t comparable functionality.

## Comparison Chart

| **Kadence block** | **Comparable default option** |
| Row layout | ✅ Row block |
| Advanced gallery | ✅ Gallery block |
| Form | ❌ In progress |
| Advanced Text | ❌ |
| Advanced Button | ✅ Buttons block |
| Tabs | ❌ |
| Accordion | ✅ Details block |
| Testimonials | ✅ Use patterns/create your own |
| Icon | ❌ |
| Spacer/Divider | ✅ Spacer block |
| Info Box | ✅ Recreate with Core blocks |
| Icon list | ❌ Under discussion |
| Countdown | ❌ |
| Posts | ✅ Posts List block |
| Table of Contents | ❌ In progress |
| Lottie Animation | ❌ |


