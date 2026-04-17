class Program
    {
        static void Main(string[] args)
        {
            Console.WriteLine("=== ATIVIDADE 1: PRODUTOS ===");
            var prodService = new ProdutoService();
            prodService.Criar(new Produto { Id = 1, Nome = "Laptop", Preco = 3500 });
            prodService.Criar(new Produto { Id = 2, Nome = "Mouse", Preco = 50 });
            prodService.Criar(new Produto { Id = 3, Nome = "Monitor", Preco = 1200 });
            
            Console.WriteLine("Produtos acima de R$ 100,00:");
            foreach (var p in prodService.ListarAcimaDe(100)) 
                Console.WriteLine($"- {p.Nome}: R$ {p.Preco}");


            Console.WriteLine("\n=== ATIVIDADE 2: CLIENTES ===");
            var cliService = new ClienteService();
            cliService.Salvar(new Cliente { Id = 1, Nome = "João", Email = "joao@email.com" });
            cliService.Salvar(new Cliente { Id = 2, Nome = "Invalido", Email = "email_sem_arroba" });
            
            var busca = cliService.BuscarPorEmail("joao@email.com");
            Console.WriteLine($"Busca por email (joao@email.com): {(busca != null ? busca.Nome : "Não encontrado")}");


            Console.WriteLine("\n=== ATIVIDADE 3: LISTA DE CURSOS ===");
            var cursos = new List<Curso>
            {
                new Curso { Id = 1, Nome = "C#", CargaHoraria = 40 },
                new Curso { Id = 2, Nome = "Java", CargaHoraria = 60 },
                new Curso { Id = 3, Nome = "Python", CargaHoraria = 20 },
                new Curso { Id = 4, Nome = "SQL", CargaHoraria = 30 },
                new Curso { Id = 5, Nome = "Angular", CargaHoraria = 45 }
            };
            var cursosFiltrados = cursos.Where(c => c.CargaHoraria > 30).OrderBy(c => c.Nome);
            Console.WriteLine("Cursos > 30h ordenados por nome:");
            foreach (var c in cursosFiltrados) Console.WriteLine($"- {c.Nome} ({c.CargaHoraria}h)");


            Console.WriteLine("\n=== ATIVIDADE 4: ESTOQUE ===");
            var estoque = new EstoqueService();
            estoque.Inserir(new ItemEstoque { Id = 1, Nome = "Caneta", Quantidade = 10 });
            estoque.BaixaEstoque(1, 5); 
            estoque.BaixaEstoque(1, 10); 
            Console.WriteLine($"Itens com estoque baixo (< 10): {estoque.ListarEstoqueBaixo(10).Count} item(ns)");


            Console.WriteLine("\n=== ATIVIDADE 5: PROFESSOR E CURSOS (1:N) ===");
            var prof = new Professor { Id = 1, Nome = "Dr. Alberto" };
            var c1 = new CursoN { Id = 1, Nome = "Matemática", Professor = prof, ProfessorId = prof.Id };
            var c2 = new CursoN { Id = 2, Nome = "Física", Professor = prof, ProfessorId = prof.Id };
            prof.Cursos.AddRange(new[] { c1, c2 });

            Console.WriteLine($"Professor: {prof.Nome}");
            // Simulação de Listar com Include
            foreach (var curso in prof.Cursos) Console.WriteLine($"  -> Curso: {curso.Nome}");


            Console.WriteLine("\n=== ATIVIDADE 6: PEDIDO E ITENS (1:N) ===");
            var pedido = new Pedido { Id = 101, Data = DateTime.Now };
            pedido.Itens.Add(new ItemPedido { Id = 1, Produto = "Cerveja", Quantidade = 12, Pedido = pedido });
            pedido.Itens.Add(new ItemPedido { Id = 2, Produto = "Carvão", Quantidade = 2, Pedido = pedido });

            Console.WriteLine($"Pedido ID: {pedido.Id}");
            Console.WriteLine($"Total de itens no pedido: {pedido.CalcularTotalItens()}");

            Console.WriteLine("\nPressione qualquer tecla para sair...");
            Console.ReadKey();
        }
    }
}
