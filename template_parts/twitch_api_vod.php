<div class="twitch_wrap-vod">
    <script src= "https://player.twitch.tv/js/embed/v1.js"></script>
    <div id="twitch-embed"></div>
    <script type="text/javascript">
        var options = {
            video: <?php echo $mostRecentId; ?>,
            playsinline: true,
            time: "0h4m40s" //Time to start the vod, set this to skip your "Start streaming timer".
        };
        var player = new Twitch.Player("twitch-embed", options);
    </script>
</div>