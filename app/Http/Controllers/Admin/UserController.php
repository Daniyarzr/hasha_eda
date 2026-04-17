<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->withCount('orders')
            ->orderByDesc('id')
            ->get();

        return view('admin.users_index', [
            'users' => $users,
        ]);
    }

    public function create(): View
    {
        return view('admin.users_create', [
            'user' => new User(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $payload = $this->validatedPayload($request);
        User::query()->create($payload);

        return redirect()->route('admin.users.index')->with('success', 'Пользователь добавлен.');
    }

    public function show(User $user): View
    {
        $user->loadCount(['orders', 'reviews', 'cartItems']);

        return view('admin.users_show', [
            'user' => $user,
        ]);
    }

    public function edit(User $user): View
    {
        return view('admin.users_edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $payload = $this->validatedPayload($request, $user);
        $isAdmin = (bool) ($payload['is_admin'] ?? false);

        if ($this->wouldLeaveNoAdmins($user, $isAdmin)) {
            return back()
                ->withInput()
                ->with('error', 'В системе должен остаться хотя бы один администратор.');
        }

        $user->update($payload);

        return redirect()->route('admin.users.index')->with('success', 'Пользователь обновлён.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($request->user()?->id === $user->id) {
            return back()->with('error', 'Нельзя удалить самого себя.');
        }

        if ($this->wouldLeaveNoAdmins($user, false)) {
            return back()->with('error', 'Нельзя удалить единственного администратора.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Пользователь удалён.');
    }

    private function validatedPayload(Request $request, ?User $user = null): array
    {
        $userId = $user?->id;

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'phone' => ['nullable', 'string', 'max:50'],
            'default_address' => ['nullable', 'string', 'max:255'],
            'password' => $user
                ? ['nullable', 'string', Password::defaults(), 'confirmed']
                : ['required', 'string', Password::defaults(), 'confirmed'],
        ]);

        $validated['email'] = Str::lower($validated['email']);
        $validated['is_admin'] = $request->boolean('is_admin');

        if (blank($validated['password'] ?? null)) {
            unset($validated['password']);
        }

        return $validated;
    }

    private function wouldLeaveNoAdmins(User $user, bool $targetIsAdmin): bool
    {
        if ($targetIsAdmin || ! $user->is_admin) {
            return false;
        }

        return User::query()
            ->where('is_admin', true)
            ->where('id', '!=', $user->id)
            ->doesntExist();
    }
}
