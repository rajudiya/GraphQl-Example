get responce using graphql => {{URL}}/graphql
BODY => 
{
  productCollection {
    allProducts {
        product_count
        name
        sku
        price
        description
        short_description
        weight
        status
        visibility
        tax_class
        quantity
        stock_availability
        categories
        attribute_set
        meta_title
        meta_description
        url_key
        manufacturer
        country_of_manufacture
        customizable_options
        ogasys_image
        categories
    }
  }
}
