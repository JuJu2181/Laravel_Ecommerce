<!-- basic requirements for table -->

category table (
    name,
    description,
    slug => unique
    image
    parent_id 0/
)
category_ids
accessories - 1 parent -0
mobile-accessories -2 ,parent -1
phone-cases -3 ,parent -2


product table(
    product_name,
    slug => unique,
    description,
    image,
    price,
    old_price
    category_id
    quantity 
    brand
    seller_id
)

Rating table(
    title
    review
    rating_number
)

Order table(
    order_details,
    products_list()
    user_id
    amount
    order_date
    order_status
    shipping information
)

cart(

)

Users(
    roles:
    admin,seller,user
    login page for users and sellers
    register page for users and sellers
    send email about order to both vendor and user
)

Order(
    order_id
    user_id
    date
    order_status
    sub_total_price
    discount
    shippping_price
    total_price
)

order_items{
    order_id
    product_id
    product_price
    quantity
    total
}