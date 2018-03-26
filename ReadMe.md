Installation
-----------------------
```composer require pkshetlie/pagination-bundle ```

add to AppKernel.php 

 ``` 
 [ 
        ...
        new Pkshetlie\PaginationBundle\PaginationBundle(), 
        ... 
 ]
 ```
 
 Add to config.yml
 
  ``` 
imports:
    ...
    - { resource: "@PaginationBundle/Resources/config/services.yml" }
  ```
  
  installation is done.
  
 Exemple Usage
 -------------------------- 
 in some Dummy controller
 
 ```php
 class DummyController extends Controller{
 
    public function indexAction(Request $request){
        $qb = $this->getDoctrine()->getReposiitory('DummyBundle:DummyEntity')->createQueryBuilder('x');
        
        // add some 
        /*
        $qb->orderBy( ... )
        $qb->where( ... )
        ...
        */        
        
        $pagination = $this->get('pkshetlie.pagination')->process($qb, $request);
        
        return $this->render('DummyBundle:Dummy:index.html.twig',[
        'pagination'=> $pagination,
        ]);
    }
 
 }
 ```
 in the index.html.twig
 
 ```twig
{% import '@Pagination/Pagination/macro.twig' as macro_pagination %}
 
 <table>
 {% for entity in pagination.entities %}
    {# ... your stuff with <tr> / <td> #}
 {% endfor %}
 </table>
 
 {# draw the pagination #}
 {{ macro_pagination.paginate(pagination) }}
 ```