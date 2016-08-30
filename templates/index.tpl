{include file='header.tpl'}

<div class="container">
  <div class="starter-template">
    <h1>Music search</h1>
    <form action="/search" method="post">
    <div class="form-group col-md-6 col-md-offset-3">
      <input placeholder="Your favourite song" type="text" class="form-control" id="query" name="query" required>
    </div>
    <div class="form-group col-md-6 col-md-offset-3">
      <input type="submit" class="btn btn-primary">
    </div>
    </form>
  </div>
</div>

{include file='footer.tpl'}