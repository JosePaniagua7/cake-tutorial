<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Articles Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 * @method \App\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
// class ArticlesController extends AppController
// {
//     /**
//      * Index method
//      *
//      * @return \Cake\Http\Response|null|void Renders view
//      */
//     public function index()
//     {
//         $this->paginate = [
//             'contain' => ['Users'],
//         ];
//         $articles = $this->paginate($this->Articles);

//         $this->set(compact('articles'));
//     }

//     /**
//      * View method
//      *
//      * @param string|null $id Article id.
//      * @return \Cake\Http\Response|null|void Renders view
//      * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
//      */
//     public function view($id = null)
//     {
//         $article = $this->Articles->get($id, [
//             'contain' => ['Users', 'Tags'],
//         ]);

//         $this->set(compact('article'));
//     }

//     /**
//      * Add method
//      *
//      * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
//      */
//     public function add()
//     {
//         $article = $this->Articles->newEmptyEntity();
//         if ($this->request->is('post')) {
//             $article = $this->Articles->patchEntity($article, $this->request->getData());
//             if ($this->Articles->save($article)) {
//                 $this->Flash->success(__('The article has been saved.'));

//                 return $this->redirect(['action' => 'index']);
//             }
//             $this->Flash->error(__('The article could not be saved. Please, try again.'));
//         }
//         $users = $this->Articles->Users->find('list', ['limit' => 200]);
//         $tags = $this->Articles->Tags->find('list', ['limit' => 200]);
//         $this->set(compact('article', 'users', 'tags'));
//     }

//     /**
//      * Edit method
//      *
//      * @param string|null $id Article id.
//      * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
//      * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
//      */
//     public function edit($id = null)
//     {
//         $article = $this->Articles->get($id, [
//             'contain' => ['Tags'],
//         ]);
//         if ($this->request->is(['patch', 'post', 'put'])) {
//             $article = $this->Articles->patchEntity($article, $this->request->getData());
//             if ($this->Articles->save($article)) {
//                 $this->Flash->success(__('The article has been saved.'));

//                 return $this->redirect(['action' => 'index']);
//             }
//             $this->Flash->error(__('The article could not be saved. Please, try again.'));
//         }
//         $users = $this->Articles->Users->find('list', ['limit' => 200]);
//         $tags = $this->Articles->Tags->find('list', ['limit' => 200]);
//         $this->set(compact('article', 'users', 'tags'));
//     }

//     /**
//      * Delete method
//      *
//      * @param string|null $id Article id.
//      * @return \Cake\Http\Response|null|void Redirects to index.
//      * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
//      */
//     public function delete($id = null)
//     {
//         $this->request->allowMethod(['post', 'delete']);
//         $article = $this->Articles->get($id);
//         if ($this->Articles->delete($article)) {
//             $this->Flash->success(__('The article has been deleted.'));
//         } else {
//             $this->Flash->error(__('The article could not be deleted. Please, try again.'));
//         }

//         return $this->redirect(['action' => 'index']);
//     }
// }
class ArticlesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('Flash');
    }

    public function index()
    {
        $this->loadComponent('Paginator');
        $articles = $this->Paginator->paginate($this->Articles->find());
        $this->set(compact(('articles')));
    }

    public function view($slug = null)
    {
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        $this->set(compact('article'));
    }

    public function add()
    {
        $article = $this->Articles->newEmptyEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());

            // Hardcoding the user_id is temporary, and will be removed later
            // when we build authentication out.
            $article->user_id = 1;
            $article->slug = $article->title;
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Unable to add your article.'));
            }
        }
        $this->set('article', $article);
    }

    public function edit($slug)
    {
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been updated'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your article'));
        }
        $this->set('article', $article);
    }

    public function delete($slug)
    {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The {0} article has been deleted. ', $article->title));
            return $this->redirect(['action' => 'index']);
        }
    }
}
