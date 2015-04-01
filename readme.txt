=== GoAbroadHQ ===
Contributors: smakinson
Tags: goabroadhq
Requires at least: 3.1
Tested up to: 4.1.1
Stable tag: 0.5.1
License: GPLv2 or later

A wordpress widget to add GoAbroadHQ fields to your website or blog. This plugin only works if you are an active client of GoAbroadHQ

== Description ==

GoAbroadHQ plugin allows you to add lead capture forms for GoAbroadHQ to your wordpress site.

You'll need GoAbroadHQ API credentials to use it. Please contact your client representitive to get the API Credentials.

== Installation ==

Upload the GoAbroadHQ plugin to your blog, Activate it, then enter your GoAbroadHQ.com API Credentials.

== Changelog ==

= 0.5.1 =
* Changed Self:: to GoAbroadHQ:: due to compatibility issues.
= 0.5.0 =
* Added compatibility check to make sure the server allows port 84 outgoing
= 0.4.5 =
* A compatibility fix by removing an unnecessary function that was functioning differently on different setups.
= 0.4.4 =
* Fixed typo in TimeZoneId where it was submitting "Mountain Standard Tim" as default instead of "Mountain Standard Time"
= 0.4.3 =
* Added a required class to required field labels.
= 0.4.2 =
* Fixed bug where page was not redirecting properly after the lead capture was submitted.
= 0.4.1 =
* Added the ability to set a url to redirect to on completion.
= 0.4.0 =
* Added the ability to set the label for each row.
= 0.3.2 =
* Fixed a problem where the inital config page was limited to the number of characters entered.
= 0.3.1 =
* It now removes configuration from the database when the plugin is deactivated.
= 0.3.0 =
* Added reCaptcha support for the lead capture widget.
= 0.2.0 =
* Added the ability to set if a field is required as well as made it so you can delete a field from the widget. Also, all available HQ fields are now present in the lead capture.
= 0.1.0 =
* Initial Plugin