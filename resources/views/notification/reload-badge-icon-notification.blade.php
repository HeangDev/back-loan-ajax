<span class="badge badge-danger navbar-badge">
    {{$loans->count()}}
</span>

<script>
    setTimeout(function() {
      System.async.reload('table_badge_icon_notifications');
    }, 5000);
</script>

<!--// Register-->
@if ($loans->count() > 0)
<script>
if(typeof(tick) == 'undefined') {
  var tick = 55;
} else {
  tick += 5;
}
if(tick >= 60) {
  tick = 0;
  var ding = new Audio('{{ asset('assets/sound/effect_ding.mp3') }}');
  ding.play();

  setTimeout(function() {
    var voice = new Audio('{{ asset('assets/sound/sound.mp3') }}');
    voice.play();
  }, 5000);
}
</script>
@endif