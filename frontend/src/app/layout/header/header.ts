import { Component, inject, signal } from '@angular/core';
import { NavigationEnd, Router, RouterLink } from '@angular/router';
import { filter } from 'rxjs';
import { AuthService } from '../../core/services/auth';

@Component({
  selector: 'app-header',
  imports: [RouterLink],
  templateUrl: './header.html',
})
export class Header {
  protected readonly auth = inject(AuthService);
  private readonly router = inject(Router);

  protected readonly isHome = signal(this.router.url === '/');

  constructor() {
    this.router.events.pipe(filter((event) => event instanceof NavigationEnd)).subscribe((event) => {
      this.isHome.set(event.urlAfterRedirects === '/');
    });
  }

  protected logout(): void {
    this.auth.logout().subscribe(() => this.router.navigate(['/']));
  }
}
