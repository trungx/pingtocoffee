<?php

namespace App\Http\Controllers;

use App\Debt;
use App\Event;
use App\Http\Requests\DebtRequest;
use App\User;

class DebtsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(User $user)
    {
        return view('contacts.debts.add', [
            'user' => $user,
            'debt' => new Debt(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DebtRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DebtRequest $request, User $user)
    {
        $debtData = [
            'from_user_id' => auth()->user()->id,
            'to_user_id' => $user->id,
        ] + $request->only(['in_debt', 'amount', 'reason']);

        $debt = Debt::create($debtData);

        // Create event log
        $debt->createLogForFeed(Event::ADD_ACTION);

        return redirect('/' . $user->username . '?tab=debts')
            ->with('success', trans('user.debts_add_success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @param Debt $debt
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user, Debt $debt)
    {
        return view('contacts.debts.edit', [
            'user' => $user,
            'debt' => $debt,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DebtRequest $request
     * @param User $user
     * @param Debt $debt
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(DebtRequest $request, User $user, Debt $debt)
    {
        $debtData = $request->only(['in_debt', 'amount', 'reason']) + [
            'from_user_id' => auth()->user()->id,
            'to_user_id' => $user->id,
        ];

        $debt->update($debtData);

        return redirect('/' . $user->username . '?tab=debts')
            ->with('success', trans('user.debts_edit_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @param Debt $debt
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(User $user, Debt $debt)
    {
        $debt->delete();

        return redirect('/' . $user->username . '?tab=debts')
            ->with('success', trans('user.debts_delete_success'));
    }
}
