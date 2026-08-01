import { Component, inject, signal } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { DatePipe } from '@angular/common';
import { PollService } from '../../../core/services/poll';
import { Poll } from '../../../core/models/poll.model';

@Component({
  selector: 'app-poll-vote',
  imports: [DatePipe],
  templateUrl: './poll-vote.html',
})
export class PollVote {
  private readonly pollService = inject(PollService);
  private readonly route = inject(ActivatedRoute);

  protected readonly poll = signal<Poll | null>(null);
  protected readonly selectedOptionId = signal<number | null>(null);
  protected readonly justVoted = signal(false);

  constructor() {
    const id = Number(this.route.snapshot.paramMap.get('id'));
    this.pollService.get(id).subscribe((response) => this.poll.set(response.data));
  }

  protected status(): 'not_started' | 'active' | 'finished' {
    const poll = this.poll();
    if (!poll) return 'not_started';

    const now = new Date();
    if (now < new Date(poll.start_date)) return 'not_started';
    if (now > new Date(poll.end_date)) return 'finished';
    return 'active';
  }

  protected vote(): void {
    const poll = this.poll();
    const optionId = this.selectedOptionId();
    if (!poll || optionId === null) return;

    this.pollService.vote(poll.id, optionId).subscribe((response) => {
      this.poll.set(response.data);
      this.justVoted.set(true);
      setTimeout(() => this.justVoted.set(false), 3000);
    });
  }
}
