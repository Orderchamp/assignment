# Assignment
## _v1.2.0_

We’d like you to create a small e-commerce application for us to get some insights in your skillset. Focus on the PHP and especially the separation of concern, the UI is optional. Please dont spend more than two hours on this assignment.

# Don’ts
- Don't spend more than two hours
- Do not include new packages

# Installation
- `git clone git@github.com:Orderchamp/assignment.git`
- `composer install`
- `npm run prod`
- `cp .env.example .env`
- `change the relevant credentials in the env file`
- `php artisan migrate`
- `php artisan db:seed`
- `php artisan serve`

# Description

Our users should be able to add products that are in stock to their shopping cart. During checkout, our visitors should be able to become users and our users should be able to review their previously
stored information (name, address, contact details).

Fifteen minutes after checkout, a user should receive a discount code of € 5,- for future purchases. If a user chooses to use a discount code, you should keep track of what discount code was applied
and what amount was subtracted from the checkout.

# Out-of-scope

The UI is optional. Payments in this application are based on invoices. Invoices are out of scope :-)

# Concessions (from the candidate)

I did not get the chance to finish the whole part of the project. Things missing:

## 15 minutes after checkout the user should get a discount code in the mail. This is not something that is too difficult to pull off, given time, and I would do it like this:

* In the checkout process, after the order is successfully created, I would generate a unique discount code for the user. (I would use events for this)
* I would store this discount code in the database, along with a reference to the user who received it and the amount of the discount.
* I would create a background job that runs 15 minutes after the order is created, which checks for orders that have not yet had a discount code generated.
* For each of these orders, the background job would generate a unique discount code, and store it in the database as described above.
* To use a discount code, the user would enter it on the checkout page. You would need to validate the discount code, and subtract the discount amount from the total price of the order and then mark
  the discount code as used
