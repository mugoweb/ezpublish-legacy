<h4>
    {if $browse_start.node_id|ne( 1 )}
        <a href="ezajaxuploader::browse::{$browse_start.parent_node_id}::{$class.id}"><img src={'up-16x16-grey.png'|ezimage()} alt="{'Go to the parent level'|i18n( 'design/admin2/ajaxuploader' )}" /></a>
    {/if}
    {foreach $browse_start.path as $pnode}
        <a href="ezajaxuploader::browse::{$pnode.node_id}::{$class.id}">{$pnode.name|wash()}</a> /
    {/foreach}
    {$browse_start.name|wash()}
</h4>
<table class="list ajaxuploader-locations">
    <tr>
        <th class="tight"></th>
        <th>{'Name'|i18n( 'design/admin2/ajaxuploader' )}</th>
        <th>{'Type'|i18n( 'design/admin2/ajaxuploader' )}</th>
        <th>{'Section'|i18n( 'design/admin2/ajaxuploader' )}</th>
    </tr>
    {foreach $browse.items as $item sequence array( 'bgdark', 'bglight' ) as $c}
    <tr class="{$c}">
        <td>
            <input type="radio" name="UploadLocation" value="{$item.node.node_id}"
                id="ajaxuploader-location{$item.node.node_id}"
                {cond( $item.can_create|not(), ' disabled="disabled"', '' )}
                {cond( $item.node.node_id|eq( $default_parent_node.node_id ), ' checked="checked"', '' )} />
        </td>
        <td>
            <label for="ajaxuploader-location{$item.node.node_id}">
            {if $item.has_child}
                <a href="ezajaxuploader::browse::{$item.node.node_id}::{$class.id}">{$item.node.name|wash()}</a>
            {else}
                {$item.node.name|wash()}
            {/if}
            </label>
        </td>
        <td>
            <label for="ajaxuploader-location{$item.node.node_id}">
            {$item.node.class_name|wash()}
            </label>
        </td>
        <td>
            <label for="ajaxuploader-location{$item.node.node_id}">
            {fetch( section, object, hash( 'section_id', $item.node.object.section_id ) ).name|wash()}
            </label>
        </td>
    </tr>
    {/foreach}
</table>
<div class="block pagination">
    <div class="left" style="text-align:right;">
        {if $browse.has_prev}
            <a href="ezajaxuploader::browse::{$browse_start.node_id}::{$class.id}::{$browse.offset|sub( $browse.limit )}">&laquo;&nbsp;{'prev'|i18n( 'design/admin2/ajaxuploader' )}</a>
        {else}
            <span>&laquo;&nbsp;{'prev'|i18n( 'design/admin2/ajaxuploader' )}</span>
        {/if}
    </div>
    <div class="right">
        {if $browse.has_next}
            <a href="ezajaxuploader::browse::{$browse_start.node_id}::{$class.id}::{$browse.offset|sum( $browse.limit )}">{'next'|i18n( 'design/admin2/ajaxuploader' )}&nbsp;&raquo;</a>
        {else}
            <span>{'next'|i18n( 'design/admin2/ajaxuploader' )}&nbsp;&raquo;</span>
        {/if}
    </div>
    <div class="break"></div>
</div>