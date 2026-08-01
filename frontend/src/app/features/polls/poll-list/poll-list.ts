import { Component, inject, signal } from '@angular/core';
import { RouterLink } from '@angular/router';
import { DatePipe, TitleCasePipe } from '@angular/common';
import { AuthService } from '../../../core/services/auth';
import { PollService } from '../../../core/services/poll';
import { Poll } from '../../../core/models/poll.model';

@Component({
  selector: 'app-poll-list',
  imports: [RouterLink, DatePipe, TitleCasePipe],
  templateUrl: './poll-list.html',
})
export class PollList {
  private readonly pollService = inject(PollService);
  protected readonly auth = inject(AuthService);

  protected readonly polls = signal<Poll[]>([]);

  constructor() {
    this.pollService.list().subscribe((response) => this.polls.set(response.data));
  }

  protected statusClasses(status: Poll['status']): string {
    return {
      'em andamento': 'bg-green-600 text-white',
      'não iniciada': 'bg-yellow-500 text-white',
      finalizada: 'bg-gray-400 text-white',
    }[status];
  }

  protected removePoll(poll: Poll): void {
    if (!confirm('Tem certeza que deseja excluir esta enquete?')) {
      return;
    }

    this.pollService.remove(poll.id).subscribe(() => {
      this.polls.update((polls) => polls.filter((p) => p.id !== poll.id));
    });
  }
}
