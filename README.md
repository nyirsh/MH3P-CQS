# QS3 >> Monster Hunter Portable 3rd Custom Quest Store

Not gonna lie, this code is very old, not commented and very messy and I don't think it will be of any use to anybody but... who knows?
I'm uploading it on GitHub after such a long time for archive purposes

# What it this?
Let me give a little introduction first: Monster Hunter is a game developed by Capcom and it's very popular in Japan.
The game concept is simple and straightforward: you choose a weapon of your likeness, use it to defeat huge monster and gather materials from them which you use to craft new gears and the cycle continues.
In order to take down a specific monster you have to complete quests and while the game came with a lot of them already is also had a "Download" functionality that allowed players to get DLC ones from the Capcom quest store.
I therefore made a patch for the game that redirected the download button to my own personal store of users' custom crafted quests.
The best part was that since all of the quests generated thru the [Custom Quest Editor](https://github.com/nyirsh/MH3P-CQE) I made were digitally signed as if Capcom made them, is was possible for players to download and install them thru the game menu even if they had an original PSP / unpatched game by using a quick and dirty DNS trick to connect to my store instead of the official one.
What you're looking at right now is the source code of not only the store part itself (which can obviously be found under the `store` folder) but also of the whole site that people used to submit their own quests to the store, or at least what's left of it.

Story time!
> I sadly was young and naive when I developed this stuff and never really took backups seriously and well, thru the age of time the code was lost and this is what I was able to recover on a very old drive of mine I randomly found one day.
> It is definitively not the latest version, the website part itself is probably not even working, the database structure got lost (even if it should be easy to recover it) but the actual store part of the project was definitively complete at this stage which, for archiving purposes, is more than enough for me

# How did you manage to get it done?
The PSP was clearly connecting over the internet in order to download the new quests and it was enough to crack open its secret using a MITM approach. It didn't take much time to realize that the game was just opening an integrated web browser pointing to this URL which, as of 2022, is still active: 

`http://crusader.capcom.co.jp/psp/MHP3rd/DL_SEL.PHP`

The only form of security that page had was relying on checking the User Agent of the browser which is the easiest thing to find and spoof:

`Capcom Portable Browser v1.4 for MonsterHunterPortable3rd`

After that it was just a matter of time and patience, browsing thru the pages and making sure that the HTML I was generating was respecting the same structure and voila!
