{include file='header.tpl'}

<div class="container">
  {foreach $response['results'] as $result}
      <div class="col-sm-3 col-sm-offset-1">
        
        <div>
          <a href="/{$result['type']}/{$result['id']}"><img src="{$result['thumb']}" class="img-thumbnail" style="height:150px; width:150px;"></a>
        </div>
        {$result['type']}
      
        {$result['title']}
      </div>
  {/foreach}
</div>

{include file='footer.tpl'}