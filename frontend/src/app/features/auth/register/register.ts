import { Component, inject, signal } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { AuthService } from '../../../core/services/auth';

@Component({
  selector: 'app-register',
  imports: [FormsModule, RouterLink],
  templateUrl: './register.html',
})
export class Register {
  private readonly authService = inject(AuthService);
  private readonly router = inject(Router);

  protected readonly name = signal('');
  protected readonly email = signal('');
  protected readonly password = signal('');
  protected readonly passwordConfirmation = signal('');
  protected readonly errors = signal<string[]>([]);

  protected submit(): void {
    this.errors.set([]);

    this.authService.register(this.name(), this.email(), this.password(), this.passwordConfirmation()).subscribe({
      next: () => this.router.navigate(['/']),
      error: (err) => this.errors.set(Object.values(err.error?.errors ?? {}).flat() as string[]),
    });
  }
}
