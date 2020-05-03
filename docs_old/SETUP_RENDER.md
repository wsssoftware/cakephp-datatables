# Setup render - [(Back)](README.md)

## Adding a custom return for each row column.

```php
/**
 * @param \DataTables\View\DataTablesView $appView
 * @param \Cake\Datasource\EntityInterface|\App\Model\Entity\Category $entity
 * @param \DataTables\Table\Renderer $renderer
 * @return void
 */
public function rowRenderer(DataTablesView $appView, EntityInterface $entity, Renderer $renderer): void {
    $renderer->add('id', $appView->Number->format($entity->id));
    $renderer->add('name', $entity->name);
    if ($entity->status === true) {
        $renderer->add('status', __('Available'));
    } else {
        $renderer->add('status', __('Unavailable'));
    }
    $renderer->add('created', h($entity->created));
    $renderer->add('modified', h($entity->created));
    $renderer->add('action', $appView->Html->link('Edit', ['action' => 'edit', $entity->idd]));
}
```

> By default, the plugin will try to automatic give each value, but it will be on yellow warning color.

