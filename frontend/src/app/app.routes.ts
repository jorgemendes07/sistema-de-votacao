import { Routes } from '@angular/router';
import { authGuard } from './core/guards/auth-guard';
import { Login } from './features/auth/login/login';
import { Register } from './features/auth/register/register';
import { PollList } from './features/polls/poll-list/poll-list';
import { PollForm } from './features/polls/poll-form/poll-form';
import { PollVote } from './features/polls/poll-vote/poll-vote';

export const routes: Routes = [
  { path: '', component: PollList },
  { path: 'login', component: Login },
  { path: 'register', component: Register },
  { path: 'polls/new', component: PollForm, canActivate: [authGuard] },
  { path: 'polls/:id/edit', component: PollForm, canActivate: [authGuard] },
  { path: 'polls/:id/vote', component: PollVote },
];
