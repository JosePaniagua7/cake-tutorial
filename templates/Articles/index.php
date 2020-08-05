<!-- File: templates/Articles/index.php -->

<h1>Articles</h1>
<table>
    <tr>
        <th>Title</th>
        <th>Created</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->
    <?= $this->Html->link('Add Article', ['action' => 'add']) ?>
    <?php foreach ($articles as $article) : ?>
        <tr>
            <td>
                <?= $this->Html->link($article->title, ['action' => 'view', $article->slug]) ?>
            </td>
            <td>
                <?= $article->created->format(DATE_RFC850) ?>
            </td>
            <td>
                <?= $this->Html->link('Editar', ['action' => 'edit', $article->slug]) ?>
                <?= $this->Form->postLink(
                    'Eliminar',
                    ['action' => 'delete', $article->slug],
                    ['confirm' => 'Are you sure you want to delete {0}', $article->title]
                ) ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>