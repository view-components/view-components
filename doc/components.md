Component Documentation
===

## Table of Contents 
- [Container](#container)
- [CollectionView](#collectionview)
- [Compounds](#compounds)
- [DataView](#dataview)
- [Json](#json)

## Container

[Container](https://github.com/view-components/view-components/blob/master/src/Component/Container.php) is a component that can store and render another components.

## CollectionView

[CollectionView](https://github.com/view-components/view-components/blob/master/src/Component/CollectionView.php) is a component for rendering data collections.
 
CollectionView::render() iterates over its data collection,
injects data elements into children components and renders it for each data item.

## Compounds

`view-components` contains several classes and interfaces for working with components composed from parts:

Class or Interface | Description
--- | ---
[Compound](https://github.com/view-components/view-components/blob/master/src/Component/Compound.php "ViewComponents\ViewComponents\Component\Compound") | Base class for components composed from parts
[PartInterface](https://github.com/view-components/view-components/blob/master/src/Base/Compound/PartInterface.php "ViewComponents\ViewComponents\Base\Compound\PartInterface") | Interface for compound part
[ContainerPartInterface](https://github.com/view-components/view-components/blob/master/src/Base/Compound/ContainerPartInterface.php "ViewComponents\ViewComponents\Base\Compound\ContainerPartInterface") | Interface for compound part
[Part](https://github.com/view-components/view-components/blob/master/src/Component/Part.php "ViewComponents\ViewComponents\Component\Part") | Wrapper that allows to use any component as compound part 

Compound parts are responsible for it's identification and location inside [Compound](https://github.com/view-components/view-components/blob/master/src/Component/Compound.php "ViewComponents\ViewComponents\Component\Compound").
Any part has "id" and "destination_parent_id" properties with corresponding getters and setters.
Value of  "destination_parent_id" should be equal to one of another part id's or Compound::ROOT_ID constant.

### Usage

#### Creating compound component

Constructor of
[Compound](https://github.com/view-components/view-components/blob/master/src/Component/Compound.php "ViewComponents\ViewComponents\Component\Compound")
can accept array of objects implementing
[PartInterface](https://github.com/view-components/view-components/blob/master/src/Base/Compound/PartInterface.php "ViewComponents\ViewComponents\Base\Compound\PartInterface").

Also [Compound](https://github.com/view-components/view-components/blob/master/src/Component/Compound.php "ViewComponents\ViewComponents\Component\Compound")
can be instantiated without arguments and parts can be added later.

#### Example 1

```php
use ViewComponents\ViewComponents\Component\Compound;
use ViewComponents\ViewComponents\Component\Html\Tag;
use ViewComponents\ViewComponents\Component\Html\TagWithText;

function makePanel() {
    $panel = new Tag('div', ['class' => 'panel panel-success']);
    $header  = new Tag('div', ['class' => 'panel-heading'], []);
    $caption = new TagWithText('b', 'Panel Header');
    $body    = new Tag('div', ['class' => 'panel-body']);
    $footer  = new TagWithText('div', 'Panel Footer', ['class' => 'panel-footer']);
    
    $compound = new Compound([
        new Part($panel, 'panel'),
        new Part($header, 'header', 'panel'),
        new Part($caption, 'caption', 'header'),
        new Part($body, 'body', 'panel'),
        new Part($footer, 'footer', 'panel'),
    ]);
    
    $body->addChildren([
        new TagWithText('p', 'Panel Body.'),
        new TagWithText('p', 'Add content here.'),
    ]);
    return $compound;
}    
echo makePanel();
```

Screenshot:

![screenshot](https://i.gyazo.com/bbefc24e94831c112175fea2294cda31.png)

See demo-application: 
[code](https://github.com/view-components/view-components/blob/master/tests/webapp/Controller.php#L252),
[demo](http://view-components.herokuapp.com/index.php/demo6)

#### Accessing Compound Parts

##### via component tree

Compound parts can ba accessed via component tree as regular components,
just don't forget that target components are wrapped to 
[Part](https://github.com/view-components/view-components/blob/master/src/Component/Part.php "ViewComponents\ViewComponents\Component\Part")
instances if that not implements
[PartInterface](https://github.com/view-components/view-components/blob/master/src/Base/Compound/PartInterface.php "ViewComponents\ViewComponents\Base\Compound\PartInterface").

```php
$compound = makePanel(); // See example 1

// will return Part instance containing $panel
$compound->children()->first(); 

// will return $panel 
$compound->children()->first()->children()->first();

// will return $caption
$caption = $compound->getChildrenRecursive()->findByProperty('tag_name', 'b', true);
$caption->setText('Updated Caption');

```

##### via `Compound::getComponent()`

`Compound::getComponent()` method has two arguments:

* string $id &mdash; compound part id
* bool $getUnderlyingComponent &mdash; optional, by default true

If you need to get Part instance, pass false to second argument,
otherwise underlying component will be returned for Part instances.

```php
$compound = makePanel(); // See example 1
$compound->getComponent('caption')->setText('New Caption');
```

#### Modifying Compound Parts

@todo

## DataView

@todo

## Json

[Json](https://github.com/view-components/view-components/blob/master/src/Component/Json.php) is a component for rendering custom data as JSON.
