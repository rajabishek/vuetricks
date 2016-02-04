<?php 

namespace Vuetricks\Repositories;

use Vuetricks\User;

interface UserRepositoryInterface
{
    /**
     * Create a new user in the database.
     *
     * @param  array $data
     * @return \Vuetricks\User
     */
    public function create(array $data);

    /**
     * Update the user in the database.
     *
     * @param  \Vuetricks\User $user
     * @param  array $data
     * @return \Vuetricks\User
     */
    public function edit(User $user, array $data);

    /**
     * Find all users paginated.
     *
     * @param  int  $perPage
     * @return Illuminate\Database\Eloquent\Collection|\Vuetricks\User[]
     */
    public function findAllPaginated($perPage = 8);

   /**
     * Find the user by the given id.
     *
     * @param  int  $id
     * @return \Vuetricks\User
     */
    public function findById($id);

    /**
     * Find the user by the given email address.
     *
     * @param  int  $email
     * @return \Vuetricks\User
     */
    public function findByEmail($email);
}