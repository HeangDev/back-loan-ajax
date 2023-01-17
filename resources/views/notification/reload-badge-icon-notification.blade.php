<span class="badge badge-danger navbar-badge">
    {{$loans->count()}}
</span>

<script>
    setTimeout(function() {
      System.async.reload('table_badge_icon_notifications');
    }, 5000);
</script>