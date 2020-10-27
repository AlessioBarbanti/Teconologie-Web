<script>
  $(function () {
  $('[data-toggle="popover"]').popover()
})
</script>

<button type="button"
class="btn"
data-container="body"
data-html = "true"
data-toggle="popover"
data-placement="top"
style="position:fixed; left: 5%; bottom: 5%; z-index: 999; color: #0088CC"
data-content="<p>Hey, sei iscritto alle nostre notifiche via Telegram? <img class='img-fluid' src='img/telegram.png' alt='QrCode for Telegram Login'> </p><br><a href='https://t.me/NinetynineTicketsBot'> https//t.me/NinetynineTicketsBot</a>"
>
<i class="fa fa-telegram fa-4x" aria-hidden="true"></i>
</button>
