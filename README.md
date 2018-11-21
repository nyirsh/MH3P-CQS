# QS3 >> Monster Hunter Portable 3rd Custom Quest Store

Not gonna lie, this project is very old and I don't think it will be any useful for new MH games but... who knows?
Maybe one day I'll come back to the scene and I realize their new quest store isn't changed that much and I can simply re-adapt this one.
I'm uploading it on GitHub after such a long time just to make sure I don't lose it if I swap drives or something like that. Just don't judge it, I was 16 y/o when I wrote this.

# What it is?
Let me give a little introduction first: Monster Hunter is a game developed by Capcom and it's very popular in Japan.
The game concept is simple and straightforward: you choose a weapon of your likeness, use it to defeat huge monster and gather materials from them which you use to craft new gears and the cycle continues.
In order to take down a specific monster you have to take part of quests. The game itself had a "Download" button that allowed you to download more quests from the Capcom website.
I made a patch so that the download button was taking the users to my own personal store of custom crafted quests.
The patch itself wasn't really necessary since a simple DNS trick could have done the job but since not everyone is a tech guy I decided to follow that way.
Point is: I developed a tool to allow anyone to easily create their own custom quests and upload them on my store so that anyone could play them, even on original consoles / games and what you're looking at is the source code of my quest store.
I crafted a whole site around it, if you're interested on how the actual store worked, just check out the "store" subfolder and ignore the rest.

# How did you manage to make it work properly?
I used a MITM approach to sniff and intercept the packages the PSP was sending out to the original Capcom store.
It didn't took much time to realize it was just calling this php page:

http://crusader.capcom.co.jp/psp/MHP3rd/DL_SEL.PHP 

If you try to connect to it without the right User Agent it will just prompt an error message. Good thing finding it was a piece of cake:

Capcom Portable Browser v1.4 for MonsterHunterPortable3rd

Spoofing UA is really easy, and once I did that I could explore it just as if I was using a PSP.
From there everything was really easy, I only needed to observe the HTML code and the behavior of their store so I could reverse engineer it and make my own.
