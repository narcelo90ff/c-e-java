using Microsoft.EntityFrameworkCore;
using ProjetoProfessorCurso.Models;

namespace ProjetoProfessorCurso.Data;

public class AppDbContext : DbContext
{
    public DbSet<Professor> Professores { get; set; }
    public DbSet<Curso> Cursos { get; set; }

    protected override void OnConfiguring(DbContextOptionsBuilder options)
        => options.UseSqlite("Data Source=escola.db");

    protected override void OnModelCreating(ModelBuilder modelBuilder)
    {
        // Configura o relacionamento 1:N explicitamente
        modelBuilder.Entity<Curso>()
            .HasOne(c => c.Professor)
            .WithMany(p => p.Cursos)
            .HasForeignKey(c => c.ProfessorId);
    }
}
