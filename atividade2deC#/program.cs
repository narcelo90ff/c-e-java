using Microsoft.EntityFrameworkCore;
using ProjetoProfessorCurso.Data;
using ProjetoProfessorCurso.Models;

using var context = new AppDbContext();

// Garante que o banco existe (alternativa à migration manual)
context.Database.EnsureCreated();

// ── INSERÇÃO ──────────────────────────────────────────────
// Evita duplicatas em execuções repetidas
if (!context.Professores.Any())
{
    var professor = new Professor
    {
        Nome = "Carlos Silva",
        Cursos = new List<Curso>
        {
            new Curso { Nome = "C# Básico" },
            new Curso { Nome = "Entity Framework" }
        }
    };

    context.Professores.Add(professor);
    context.SaveChanges();

    Console.WriteLine("✅ Professor e cursos inseridos com sucesso!\n");
}

// ── CONSULTA COM INCLUDE ──────────────────────────────────
var professores = context.Professores
    .Include(p => p.Cursos)
    .AsNoTracking()       // ✅ melhor performance para leitura
    .ToList();

foreach (var prof in professores)
{
    Console.WriteLine($"👨‍🏫 Professor: {prof.Nome} (Id: {prof.Id})");

    if (prof.Cursos.Count == 0)
    {
        Console.WriteLine("   Nenhum curso associado.");
        continue;
    }

    foreach (var curso in prof.Cursos)
        Console.WriteLine($"   📘 Curso: {curso.Nome} (Id: {curso.Id})");

    Console.WriteLine();
}
