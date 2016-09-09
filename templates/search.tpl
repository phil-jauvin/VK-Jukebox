{include file='header.tpl'}

<div class="container" style="margin-top: 10vh;">
  {foreach $response['results'] as $result}
      <div class="col-sm-3 col-sm-offset-1">
        
        <div>
          <a href="/{$result['type']}/{$result['id']}">
           <img src="{if !empty($result['thumb'])}{$result['thumb']}{else}/templates/img/default-artist.png{/if}" class="img-thumbnail" style="height:150px; width:150px;">
          </a>
        </div>
        {$result['type']}
      
        {$result['title']}
      </div>
  {/foreach}
</div>

{include file='footer.tpl'}