# Zenbox Magento endpoint #

## What is Zenbox? ##
Zenbox is a browser extension that connects all of your SaaS services, like Desk.com, Stripe, Shopify, Mailchimp, Salesforce, and more. [Zenboxapp.com](http://zenboxapp.com)

## What does this endpoint do? ##
When you have an email from one of your clients open, it will look in your Magento shop to see if this customer has an account. If so, it will display his/her name. If the customer also placed some orders, it'll show the individual turnover and the last item purchased. You can also use the Actions dialog to open the client in the Magento backend directly or go to their last order.

## How do I configure this? ##
First, install the [Zenbox Chrome Extension](https://chrome.google.com/webstore/detail/zenbox/mlkjemamfkkbldipgchdhfghamhmdchg). In the extension Settings page, create an account and click on Custom Data. As your Custom Data URL, use;
```
http://www.yourdomain.com/zenbox/?auth=YOURAUTHKEY&domain=WWW.YOURDOMAIN.COM&user=YOURAPIUSER&key=YOURAPIKEY
```
You have to create a Web Services account in your Magento backend. Fill in the API user & key in the Custom Data URL. Make up your own auth key to protect the script from being used by other people.
The script itself doesn't need to be placed on thesame server as your Magento installation; it can be run from anywhere.

## Contact ##
GitHub: https://github.com/peterjaap
Twitter: https://twitter.com/PeterJaap
Email: peterjaap@elgentos.nl