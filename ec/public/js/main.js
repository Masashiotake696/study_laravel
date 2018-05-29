$(function() {
  $('.delete').click(function() {
    if(confirm('削除してもよろしいですか?')) {
      $('#form_' + this.dataset.id).submit();
    }
  });
});
