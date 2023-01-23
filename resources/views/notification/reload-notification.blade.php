@foreach($loans as $row )
<a href="{{route('admin.loan.index')}}" class="dropdown-item" onclick="approve_loan({{$row->id}})">
  <input type="hidden" value="{{$row->id}}" id="loan_id">
    <!-- Message Start -->
    <div class="media">
        <div class="media-body">
            <h3 class="dropdown-item-title">
                {{$row->document_id->name}} {{$row->customer->tel}}
            <span class="float-right text-sm"><i class="fas fa-star"></i></span>
            </h3>
            <p class="text-sm text-muted">ต้องการกู้เงินจำนวน</p>
            <p class="text-sm"><i class="far fa-money-bill-alt"></i> {{number_format($row->amount)}} บาท</p>
        </div>
    </div>
    <!-- Message End -->
  </a>
  <div class="dropdown-divider"></div>
  @endforeach

  @foreach($withdraws as $row )
<a href="{{route('admin.withdraw.index')}}" class="dropdown-item" onclick="approve_withdraw({{$row->id}})">
  <input type="hidden" value="{{$row->id}}" id="loan_id">
    <!-- Message Start -->
    <div class="media">
        <div class="media-body">
            <h3 class="dropdown-item-title">
                {{$row->document_id->name}} {{$row->customer->tel}}
            <span class="float-right text-sm"><i class="fas fa-star"></i></span>
            </h3>
            <p class="text-sm text-muted">แจ้งถอนเงินจำนวน</p>
            <p class="text-sm"><i class="far fa-money-bill-alt"></i> {{number_format($row->withdraw_amount)}} บาท</p>
        </div>
    </div>
    <!-- Message End -->
  </a>
  <div class="dropdown-divider"></div>
  @endforeach

<script type="text/javascript">
   function approve_loan(id)
    {
      $.ajax({
              //some ajax call to deal with your approve link
              url: "{{ url('notification/readed-notification-loan') . '/' }}" + id,
              type: "POST",
              data: "id="+id,
              // success: function (data) { 
              //     alert('updated');
              // }
      });
    }

    function approve_withdraw(id)
    {
      $.ajax({
              //some ajax call to deal with your approve link
              url: "{{ url('notification/readed-notification-withdraw') . '/' }}" + id,
              type: "POST",
              data: "id="+id,
              // success: function (data) { 
              //     alert('updated');
              // }
      });
    }
    
</script>
<script>
    setTimeout(function() {
      System.async.reload('table_notifications');
    }, 5000);
</script>