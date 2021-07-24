# TWITCH API LIVE/VOD DISPLAY :innocent:
## What does it do?
This project allows you to dynamically display your Twitch stream on your Wordpress Website.

It will automatically check if you are live when a user visits your website, if you are, it will display your live stream, if not, it will display your most recent VOD with a customisable start time to account for "Starting Stream" countdowns.

## Wordpress File Structure
- "twitch_api_live_vod_display.php" should be placed either in your "functions.php" file or where you call your theme functions from externally.
- "twitch_api_live.php" & "twitch_api_vod.php" should be placed alongside your template parts - locations for these can be customised, you will however, need to edit the path in the main file.

## What information do I need?
You will need to sign up to the Twitch API and recieve the following:
- Your Client ID
- Your Token

You will also need to grab the ID of the channel you are using.
You can find this using many methods, but the easiest and quickest way is to use a chrome extension.

## Set up
- Once you have placed the files in the correct location, you will need to enter your Client ID & Token into "twitch_api_live_vod_display.php"
- You will then need to place your channel ID into "twitch_api_vod.php"
- Lastly place your channel name into "twitch_api_live.php"

## All Done! :purple_heart: