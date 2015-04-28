 SC.initialize({
    client_id: "82bbfbb611ea601c42b750a83a4c0749",
    redirect_uri: "http://google.com",
  });

//Gets a playlist and embeds it in the apge
SC.get('/playlists/96517157', function(playlist) {
  SC.oEmbed(playlist.permalink_url, document.getElementById('player'));
});