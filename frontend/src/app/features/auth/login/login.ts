import { Component, inject, signal } from '@angular/core';
import { Router } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { AuthService } from '../../../core/services/auth';

@Component({
  selector: 'app-login',
  imports: [FormsModule],
  templateUrl: './login.html',
})
export class Login {
  private readonly authService = inject(AuthService);
  private readonly router = inject(Router);

  protected readonly email = signal('');
  protected readonly password = signal('');
  protected readonly error = signal<string | null>(null);

  protected submit(): void {
    this.error.set(null);

    this.authService.login(this.email(), this.password()).subscribe({
      next: () => this.router.navigate(['/']),
      error: () => this.error.set('Credenciais inválidas.'),
    });
  }
}
