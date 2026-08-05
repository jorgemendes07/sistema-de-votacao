import { Component, inject, signal } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { PollService } from '../../../core/services/poll';

@Component({
  selector: 'app-poll-form',
  imports: [FormsModule],
  templateUrl: './poll-form.html',
})
export class PollForm {
  private readonly pollService = inject(PollService);
  private readonly route = inject(ActivatedRoute);
  private readonly router = inject(Router);

  protected readonly pollId = signal<number | null>(null);
  protected readonly title = signal('');
  protected readonly startDate = signal('');
  protected readonly endDate = signal('');
  protected readonly options = signal<string[]>(['', '']);
  protected readonly errors = signal<string[]>([]);

  protected readonly isEditing = () => this.pollId() !== null;

  constructor() {
    const idParam = this.route.snapshot.paramMap.get('id');

    if (idParam) {
      const id = Number(idParam);
      this.pollId.set(id);

      this.pollService.get(id).subscribe((response) => {
        const poll = response.data;

        if (!poll.owned_by_current_user) {
          this.router.navigate(['/']);
          return;
        }

        this.title.set(poll.title);
        this.startDate.set(poll.start_date.slice(0, 16));
        this.endDate.set(poll.end_date.slice(0, 16));
        this.options.set(poll.options.map((option) => option.option_text));
      });
    }
  }

  protected addOption(): void {
    this.options.update((options) => [...options, '']);
  }

  protected updateOption(index: number, value: string): void {
    this.options.update((options) => options.map((option, i) => (i === index ? value : option)));
  }

  protected submit(): void {
    this.errors.set([]);

    const id = this.pollId();
    const payload = {
      title: this.title(),
      start_date: this.startDate(),
      end_date: this.endDate(),
    };

    const request$ = id
      ? this.pollService.update(id, payload)
      : this.pollService.create({ ...payload, options: this.options().filter((o) => o.trim() !== '') });

    request$.subscribe({
      next: (response) => this.router.navigate(['/polls', response.data.id, 'vote']),
      error: (err) => {
        const fieldErrors = Object.values(err.error?.errors ?? {}).flat() as string[];
        this.errors.set(fieldErrors.length > 0 ? fieldErrors : [err.error?.message ?? 'Não foi possível salvar a enquete.']);
      },
    });
  }
}
