<script>
  $('#sampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var recipient = button.data('recipient');
    var modal = $(this);
    modal.find('.modal-title').text(recipient + 'へのメッセージ');
  });
</script>