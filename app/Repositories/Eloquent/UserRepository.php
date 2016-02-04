<?php 

namespace Vuetricks\Repositories\Eloquent;

use Vuetricks\User;
use Vuetricks\Repositories\UserRepositoryInterface;
use Vuetricks\Exceptions\UserNotFoundException;
use Illuminate\Contracts\Hashing\Hasher;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * User model.
     *
     * @var \Vuetricks\User
     */
    protected $model;

    /**
     * Bcrypt hasher to hash the password.
     *
     * @var \Illuminate\Contracts\Hashing\Hasher
     */
    protected $hasher;

    /**
     * Create a new DbUserRepository instance.
     *
     * @param  \Vuetricks\User  $user
     * @return void
     */
    public function __construct(User $user, Hasher $hasher)
    {
        $this->model = $user;
        $this->hasher = $hasher;
    }

    /**
     * Create a new user in the database.
     *
     * @param  array $data
     * @return \Vuetricks\User
     */
    public function create(array $data)
    {
        $user = $this->getNew();
        
        $user->username = $data['username'];
        $user->email    = $data['email'];

        if(isset($data['provider_id']))
            $user->provider_id = $data['provider_id'];
        
        if(isset($data['password']))
            $user->password = $this->hasher->make($data['password']);
        
        $user->save();

        return $user;
    }

    /**
     * Update the user in the database.
     *
     * @param  \Vuetricks\User $user
     * @param  array $data
     * @return \Vuetricks\User
     */
    public function edit(User $user, array $data)
    {
        if(isset($data['username']))
            $user->username  = $data['username'];

        if(isset($data['email']))
            $user->email  = $data['email'];
        
        if(isset($data['password']))
            $user->password = $$this->hasher->make($data['password']);

        $user->save();

        return $user;
    }

    /**
     * Find all users paginated.
     *
     * @param  int  $perPage
     * @return Illuminate\Database\Eloquent\Collection|\Vuetricks\User[]
     */
    public function findAllPaginated($perPage = 8)
    {
        return $this->model->orderBy('created_at', 'desc')
                           ->paginate($perPage);
    }

   /**
     * Find the user by the given id.
     *
     * @param  int  $id
     * @return \Vuetricks\User
     */
    public function findById($id)
    {
        $user = $this->model->find($id);

        if(is_null($user))
            throw new UserNotFoundException("The user with id as $id does not exist.");

        return $user;
    }

    /**
     * Find the user by the given email address.
     *
     * @param  int  $email
     * @return \Vuetricks\User
     */
    public function findByEmail($email)
    {
        $user = $this->model->where('email',$email)->first();

        if(is_null($user))
            throw new UserNotFoundException("The user with id as $id does not exist.");

        return $user;
    }

    /**
     * Find the user from the given provider token.
     *
     * @param  int  $token
     * @return \Vuetricks\User
     */
    public function findByProviderToken($token)
    {
        $user = $this->model->where('provider_id',$token)->first();

        if(is_null($user))
            throw new UserNotFoundException("The user with provider_id as $token does not exist.");

        return $user;
    }

    /**
     * Return user if exists; create and return if doesn't from the given data
     *
     * @param $data
     * @return \Vuetricks\User
     */
    public function findOrCreateUserFromProviderData($data)
    {
        try 
        {
            return $this->findByProviderToken($data->id);
        } 
        catch(UserNotFoundException $e) 
        {
            return $this->create([
                'username' => $data->nickname,
                'email' => $data->email,
                'provider_id' => $data->id
            ]);   
        }
    }
}
