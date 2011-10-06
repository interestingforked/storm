<h1>Products</h1>

<table class="data">
    <tr>
        <th>ID</th>
        <th>URL</th>
        <th>Categories</th>
        <th>Title</th>
        <th>Status</th>
        <th>Sort</th>
        <th>Created</th>
        <th>Action</th>
    </tr>
<?php foreach ($data AS $product): ?>
<tr>
    <td align="center"><?php echo $product['product']->id; ?></td>
    <td><?php echo $product['product']->slug; ?></td>
    <td><?php 
    $categoryList = array();
    foreach ($product['categories'] AS $category):
        $link = "";
        if (count($category) > 1) {
            $link = CHtml::link($category[0]->content->title, array('/crud/category/edit/'.$category[0]->id)).' > ';
            array_shift($category);
        }
        $link .= CHtml::link($category[0]->content->title, array('/crud/category/edit/'.$category[0]->id));
        $categoryList[] = $link;
    endforeach;
    echo implode('<br/>', $categoryList);
    ?></td>
    <td><?php echo Chtml::link($product['product']->content->title, array('/crud/product/edit/'.$product['product']->id)); ?></td>
    <td align="center"><?php echo ($product['product']->active == 1) ? 'Active' : 'Not active'; ?></td>
    <td align="center"><?php echo $product['product']->sort; ?></td>
    <td align="center"><?php echo $product['product']->created; ?></td>
    <td align="center">
        <?php
        echo Chtml::link('View', array('/product/'.$product['product']->slug.'-'.$product['product']->id));
        echo ' / ';
        echo Chtml::link('Edit', array('/crud/product/edit/'.$product['product']->id));
        echo ' / ';
        echo Chtml::link('Nodes', array('/crud/productnode/index/'.$product['product']->id));
        echo ' / ';
        echo Chtml::link('Delete', array('/crud/product/delete/'.$product['product']->id));
        ?>
    </td>
</tr>
<?php endforeach; ?>
</table>
<div class="action-area">
    <?php echo Chtml::link('New product', array('/crud/product/new')); ?>
</div>