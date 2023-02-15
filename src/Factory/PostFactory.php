<?php

namespace App\Factory;

use App\Entity\Post;
use App\Repository\PostRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Post>
 *
 * @method        Post|Proxy create(array|callable $attributes = [])
 * @method static Post|Proxy createOne(array $attributes = [])
 * @method static Post|Proxy find(object|array|mixed $criteria)
 * @method static Post|Proxy findOrCreate(array $attributes)
 * @method static Post|Proxy first(string $sortedField = 'id')
 * @method static Post|Proxy last(string $sortedField = 'id')
 * @method static Post|Proxy random(array $attributes = [])
 * @method static Post|Proxy randomOrCreate(array $attributes = [])
 * @method static PostRepository|RepositoryProxy repository()
 * @method static Post[]|Proxy[] all()
 * @method static Post[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Post[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Post[]|Proxy[] findBy(array $attributes)
 * @method static Post[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Post[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class PostFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'author' => UserFactory::random(),
            'category' => CategoryFactory::random(),
            'content' => '<div><strong>Labore quia sint iste neque dolorem et. </strong>Ducimus occaecati ut voluptate earum animi fugit delectus. Corporis fuga atque vel assumenda aut omnis dolores qui. Ab repudiandae sunt dolore a fugiat libero voluptas non. Veritatis commodi delectus similique veniam officia quaerat maxime. Ex voluptas saepe soluta sit tempora unde. Et dolores sed nobis ullam voluptatem itaque doloribus cum. Et et et fugit in omnis. Sunt ea adipisci quia explicabo praesentium. Doloremque rerum fugit quis temporibus alias. Facilis reiciendis at et facilis. Alias asperiores et ipsum error beatae.&nbsp;<br><br>Est animi deleniti reiciendis voluptatem sit autem ipsum non. Molestiae facilis sint asperiores consequatur. Sunt maiores itaque quisquam. Quae et dolorem voluptatem nihil assumenda qui aliquam. Saepe id repellat quas ut omnis aut. Qui temporibus quidem iusto blanditiis sed nihil ducimus. Fugit omnis repellendus eligendi dolorem consectetur reprehenderit debitis. Et aut qui magnam omnis consequatur quod nam. Nobis et repellendus quis itaque voluptatem ratione. Qui aut molestiae eligendi dolores sed possimus ratione. Hic odio et autem nihil aliquid. Molestiae earum nostrum veritatis adipisci recusandae. Perspiciatis ratione incidunt fugiat qui sequi consequuntur repellendus.&nbsp;<br><br>Nemo amet dolores corrupti velit. Est ea expedita dolore et culpa architecto earum. Eum voluptates omnis quis exercitationem ut maxime sed. Quia sed asperiores velit quo. Saepe aut placeat nemo minima deserunt. Ut sapiente qui autem voluptates dicta vel. Cumque architecto sapiente deleniti dolorem ea cupiditate. Est animi deleniti reiciendis voluptatem sit autem ipsum non. Molestiae facilis sint asperiores consequatur. Sunt maiores itaque quisquam. Quae et dolorem voluptatem nihil assumenda qui aliquam. Saepe id repellat quas ut omnis aut. Qui temporibus quidem iusto blanditiis sed nihil ducimus. Fugit omnis repellendus eligendi dolorem consectetur reprehenderit debitis. Et aut qui magnam omnis consequatur quod nam. Nobis et repellendus quis itaque voluptatem ratione. Qui aut molestiae eligendi dolores sed possimus ratione. Hic odio et autem nihil aliquid. Molestiae earum nostrum veritatis adipisci recusandae. Perspiciatis ratione incidunt fugiat qui sequi consequuntur repellendus.&nbsp;<br><br>Est animi deleniti reiciendis voluptatem sit autem ipsum non. Molestiae facilis sint asperiores consequatur. Sunt maiores itaque quisquam. Quae et dolorem voluptatem nihil assumenda qui aliquam. Saepe id repellat quas ut omnis aut. Qui temporibus quidem iusto blanditiis sed nihil ducimus. Fugit omnis repellendus eligendi dolorem consectetur reprehenderit debitis. Et aut qui magnam omnis consequatur quod nam. Nobis et repellendus quis itaque voluptatem ratione. Qui aut molestiae eligendi dolores sed possimus ratione. Hic odio et autem nihil aliquid. Molestiae earum nostrum veritatis adipisci recusandae. Perspiciatis ratione incidunt fugiat qui sequi consequuntur repellendus.&nbsp;<br><br>Nemo amet dolores corrupti velit. Est ea expedita dolore et culpa architecto earum. Eum voluptates omnis quis exercitationem ut maxime sed. Quia sed asperiores velit quo. Saepe aut placeat nemo minima deserunt. Ut sapiente qui autem voluptates dicta vel. Cumque architecto sapiente deleniti dolorem ea cupiditate. Est animi deleniti reiciendis voluptatem sit autem ipsum non. Molestiae facilis sint asperiores consequatur. Sunt maiores itaque quisquam. Quae et dolorem voluptatem nihil assumenda qui aliquam. Saepe id repellat quas ut omnis aut. Qui temporibus quidem iusto blanditiis sed nihil ducimus. Fugit omnis repellendus eligendi dolorem consectetur reprehenderit debitis. Et aut qui magnam omnis consequatur quod nam. Nobis et repellendus quis itaque voluptatem ratione. Qui aut molestiae eligendi dolores sed possimus ratione. Hic odio et autem nihil aliquid. Molestiae earum nostrum veritatis adipisci recusandae. Perspiciatis ratione incidunt fugiat qui sequi consequuntur repellendus.&nbsp;<br><br></div>',
            'title' => self::faker()->text(60),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Post $post): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Post::class;
    }
}
