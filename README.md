# Auto Products Schema for WooCommerce

A small WordPress plugin that adds Product schema (JSON-LD) to every WooCommerce product page. No settings, no UI. Activate it and the markup appears in the page `<head>`.

Version 1.0 · Author: [Suraj Dev](https://www.surajdev.com)

## What it outputs

On single product pages only, the plugin prints one `application/ld+json` block with:

- `name`: the product title
- `image`: the main product image URL
- `description`: the product's long description
- `sku`: the SKU
- `brand`: read from a product attribute named `brand`
- `offers`: currency, price, availability (`InStock` or `OutOfStock`) and the product URL

Example output:

```json
{
  "@context": "http://schema.org",
  "@type": "Product",
  "name": "Example Product",
  "image": "https://example.com/wp-content/uploads/example.jpg",
  "description": "Product description.",
  "sku": "EX-001",
  "brand": { "@type": "Brand", "name": "ExampleBrand" },
  "offers": {
    "@type": "Offer",
    "priceCurrency": "INR",
    "price": "499",
    "availability": "http://schema.org/InStock",
    "url": "https://example.com/product/example/"
  }
}
```

## Install

1. Create a folder `auto-schema-products-wc` in `wp-content/plugins/`.
2. Put `auto-schema-products-wc.php` inside it.
3. Activate **Auto Schema Products WC** under Plugins in your WordPress admin.

Requires WooCommerce. The plugin does nothing on non-product pages.

## Add a brand

The `brand` field comes from a product attribute with the slug `brand`. In WooCommerce, add a custom attribute called "brand" to each product, or create a global attribute named Brand under Products → Attributes. Products without it get an empty brand name.

## Check that it works

1. Open a product page and view the page source. Search for `application/ld+json`.
2. Paste the product URL into Google's [Rich Results Test](https://search.google.com/test/rich-results).
3. Confirm the Product item is detected with no errors.

## Read this before you install

**WooCommerce already outputs its own Product schema.** So do Yoast SEO, Rank Math and most SEO plugins. If you run this plugin next to any of them, each product page ends up with two or three competing Product blocks, and Google may flag duplicates or conflicts. Test with the Rich Results Test first. Use this plugin only if your site has no other source of Product markup, or if you've turned the others off.

## Known limitations

- Variable products: `price` is the product's current price, which for variable products is the lowest variation price. Per-variation offers are not output.
- No ratings or reviews (`aggregateRating`, `review`).
- No shipping or return policy fields, which Google's merchant listings can use.
- `description` is the raw long description and can contain HTML tags.
- Products with no featured image output an empty `image` value.
- Uses `http://schema.org` URLs. Google accepts these, but `https://schema.org` is current.

These are the places a contribution would help most.

## Contributing

Issues and pull requests are welcome. If you open a bug, include the product type (simple or variable), a link to the page and the Rich Results Test result.

## License

GPL-2.0-or-later, the standard license for WordPress plugins. See [LICENSE](LICENSE).
