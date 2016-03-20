Mala Demo
=========

This project demostrates how to use [Mala](https://github.com/chrisyue/mala),
a PHP lib to transform your m3u8 files into a http live stream, with Symfony and Doctrine

Tutorial
--------

To make a http live stream, you should need some model:

- A `Channel`, which implements `Chrisyue\Mala\Model\ChannelInterface`
- A `Video`, which implements `Chrisyue\Mala\Model\VideoInterface`
- A `ProgramInterface`, which implements `Chrisyue\Mala\Model\ProgramInterface`
- The last thing, a ScheduledMediaSegment, which is already a class, represent a m3u8 [media segment](https://tools.ietf.org/html/draft-pantos-http-live-streaming-18#page-5)

In a Symfony project, those model would like to be entities(in the `src/AppBundle/Entity`)

And also, we need some manager to manipulate those models:

- `EpgManager`, which implements `Chrisyue\Mala\Manager\EpgManagerInterface`, manages programs
- `MediaSegmentsManager`, which implements `Chrisyue\Mala\Manager\MediaSegmentManagerInterface`
- `VideoManager`, which implements `Chrisyue\Mala\Manager\VideoManagerInterface`

They are located in `src/AppBundle/Manager`, except `VideoManger`,
because `VideoManager` is only used to fetch videos, which is much like a `EntityRepository` in
a Symfony + Doctrine project.

So `VideoRepository` implements the `Chrisyue\Mala\Manager\VideoManagerInterface`
instead of `VideoManager`. It's located in `src/AppBundle/Entity`

You can check the source code of this project to see more details

You can try Mala using this demo
--------------------------------

First of all, you should create the database and schema:

```
$ php app/console doctrine:database:create
$ php app/console doctrine:schema:create
```

then create a channel:

```
$ php app/console app:channel:create
```

which should create a channel. you should check the channel id in the database

after the channel is created, create some videos:

```
$ php app/console app:video:create <channel-id> <m3u8-url>
```

after the video is created, you can schedule epg of the channel with those videos in a specified period:

```
$ php app/console app:epg:schedule <channel-id> --starts-at='now' --ends-at='tomorrow'
```

`starts-at` and `ends-at` can be any phrase you can use in PHP `strtotime` function

then you can schedule the playlist:

```
$ php app/console app:playlist:schedule <channel-id> --starts-at='now' --ends-at='tomorrow'
```

start the server by

```
$ php app/console server:start
```

finally you can browse the hls uri `http://localhost:8000/<channel-id>.m3u8` to check if there are errors.

if no error raised you can use VLC or Quicktime or other players supporting hls to see the http live channel you've created!
