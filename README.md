# xi-web-modelviewer

An FBX model viewer that is designed for FFXI assets exported from xidata

## Running

This is designed to be used in conjunction with the data exported from: https://github.com/vekien/xidata/releases/tag/v1.2.1

> If you have not exported FBX files from that program, this model viewer wont work. It does not load from the game files.

Make sure your directory structure is like so:

```
FF11 Assets /
   Animations /
   Gear /
   NPC 1 /
   ...
   xi-web-modelviewer / viewer.html
```

You can use any web server, I simply use VS Code Live Server plugin:
- https://marketplace.visualstudio.com/items?itemName=ritwickdey.LiveServer

With this installed, simply right-click the `viewer.html` and click "Open with Live Server" and you're good to go!