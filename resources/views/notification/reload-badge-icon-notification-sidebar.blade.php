<span class="badge badge-info right">
    {{$loans->count()}}
</span>

<script>
    setTimeout(function() {
      System.async.reload('table_badge_icon_sidebar_notifications');
    }, 5000);
</script>